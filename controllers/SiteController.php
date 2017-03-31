<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\SVController;
use app\components\common;
use app\models\LoginForm;


class SiteController extends SVController {

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

    public function actionLogin() {
        $this->layout = 'login';
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goHome();
        }

        return $this->render('login/login', [
            'model'         => $model,
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->urlManager->createUrl("/"));
    }

}
