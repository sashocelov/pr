<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\SBController;
use app\components\common;
use app\models\LoginForm;

use app\models\Groups;
use app\models\Groupplaces;

class SiteController extends SBController {

    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex() {
        return $this->render('index', [
        ]);
    }

    public function actionLogingroup() {
        $this->layout = 'login';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post())) {
            $pGroup = Groups::findOne([
                    'username' => $model->username,
                    'password' => md5($model->password),
                ]);
            if (!empty($pGroup)) {
                if ($pGroup->active == 1) {
                    $aAttr = $pGroup->attributes;
                    unset($aAttr['username']);
                    unset($aAttr['password']);
                    unset($aAttr['active']);
                    common::setAuthState('group', $aAttr);
                    $this->redirect(\Yii::$app->urlManager->createUrl("/loginpl"));
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Групата не е активна, моля свържете се с хората, обслужващи софтуера.'));
                }
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Грешно потребителско име или парола.'));
            }
        }

        return $this->render('login/loginGroup', [
            'model' => $model,
        ]);
    }

    public function actionLoginplace() {
        $this->layout = 'login';
        $pGroup = common::getAuthState('group');

        if (empty($pGroup) && !isset($pGroup['id'])) {
            $this->redirect(Yii::$app->urlManager->createUrl("/logingr"));
        }

        $model = new LoginForm();
        $pGroupPlaces = $pTmp = Groupplaces::findAll([
                'group_id'  => $pGroup['id'],
                'active'    => '1',
            ]);
        if ($model->load(Yii::$app->request->post())) {
                $pGroupPlaces = Groupplaces::findOne([
                    'group_id'  => $pGroup['id'],
                    'password'  => md5($model->password),
                ]);

                if (!empty($pGroupPlaces)) {
                    if ($pGroupPlaces->active == 1 && $this->actionGroupPlacePermission($pGroupPlaces)) {
                        $aAttr = $pGroupPlaces->attributes;
                        $this->actionSaveGroupPlace($aAttr);
                    } else {
                        Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Обектът не е активен, моля свържете се с хората, обслужващи на софтуера.'));
                    }
                } else {
                    Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Грешнa парола. Моля опитайте отново.'));
                }
                $pGroupPlaces = $pTmp;
        } else {
            if (count($pGroupPlaces) == 1) {
                $pGroupPlaces = $pGroupPlaces[0]->attributes;
                if ($pGroupPlaces['password'] == NULL && $this->actionGroupPlacePermission($pGroupPlaces)) {
                    $pGroupPlaces['one_place'] = 1;
                    $this->actionSaveGroupPlace($pGroupPlaces);
                }
                $aTmp = $pGroupPlaces;
                $pGroupPlaces = null;
                $pGroupPlaces[0] = $aTmp;
            }
        }

        return $this->render('login/loginPlace', [
            'model'         => $model,
            'groupTitle'    => $pGroup['title'],
            'pGroupPlaces'  => $pGroupPlaces
        ]);
    }

    public function actionLoginfreeplace() {
        if (isset($_GET['id']) && intval($_GET['id']) == $_GET['id']) {
            $pGroup = common::getAuthState('group');

            if (empty($pGroup) && !isset($pGroup['id'])) {
                $this->redirect(Yii::$app->urlManager->createUrl("/logingr"));
            }

            $pGroupPlaces = Groupplaces::findOne([
                    'group_id'  => $pGroup['id'],
                    'id'        => $_GET['id'],
                    'active'    => '1',
                ]);
            if ($pGroupPlaces['password'] == NULL && $this->actionGroupPlacePermission($pGroupPlaces)) {
                    $pGroupPlaces['one_place'] = 1;
                    $this->actionSaveGroupPlace($pGroupPlaces);
            } else {
                $this->actionLogoutplace();
            }
        }
    }

    private function actionSaveGroupPlace($aAttr) {
        unset($aAttr['group_id']);
        unset($aAttr['password']);
        unset($aAttr['password']);
        unset($aAttr['is_bought']);
        unset($aAttr['active']);
        common::setAuthState('place', $aAttr);
        $this->redirect(Yii::$app->urlManager->createUrl("/login"));
    }

    private function actionGroupPlacePermission($pGroupPlace) {
        // Проверка, дали е платено
        return true;
    }

    public function actionLogin() {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $aPlace = common::getAuthState('place');
        if (empty($aPlace) && !isset($aPlace['id'])) {
            $this->redirect(Yii::$app->urlManager->createUrl("/loginpl"));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        $strBgUrl = '';
        if (!empty($aPlace['group_data'])) {
            $aData = unserialize($aPlace['group_data']);
            if (isset($aData['bg'])) {
                $strBgUrl = $aData['bg'];
            }
        }

        $bReturnToGroup = false;
        if (isset($aPlace['one_place']) && $aPlace['one_place'] == 1) {
            $bReturnToGroup = true;
        }

        return $this->render('login/login', [
            'model'         => $model,
            'placeTitle'    => $aPlace['title'],
            'strBgUrl'      => $strBgUrl,
            'bReturnToGroup'=> $bReturnToGroup
        ]);
    }

    public function actionLogout() {
        $aGroup = common::getAuthState('group');
        $aPlace = common::getAuthState('place');
        Yii::$app->user->logout();
        common::setAuthState('group', $aGroup);
        common::setAuthState('place', $aPlace);
        $this->redirect(Yii::$app->urlManager->createUrl("/login"));
    }

    public function actionLogoutplace() {
        $aGroup = common::getAuthState('group');
        Yii::$app->user->logout();
        common::setAuthState('group', $aGroup);
        common::clearAuthState('place');
        $this->redirect(Yii::$app->urlManager->createUrl("/loginpl"));
    }

    public function actionLogoutgroup() {
        Yii::$app->user->logout();
        common::clearAuthState('group');
        common::clearAuthState('place');
        $this->redirect(Yii::$app->urlManager->createUrl("/logingr"));
    }
}
