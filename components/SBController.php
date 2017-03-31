<?php
namespace app\components;
use Yii;
use yii\web\Controller;
use app\components\common;


class SBController extends Controller {
	public function __construct($id, $module, $config = [])
	{
		if (!$this->checkGroup() &&	(
					Yii::$app->request->pathInfo != 'logingr'
						&&
					Yii::$app->request->pathInfo != 'loginpl'
					)
				) {
			// echo Yii::$app->request->pathInfo;die;
			$this->redirect(Yii::$app->urlManager->createUrl("/logingr"));
		}
	    parent::__construct($id, $module, $config);
	}

	private function checkGroup() {
		$pGroup = common::getAuthState('group');
		if (!empty($pGroup) && intval($pGroup['id']) == $pGroup['id']) {
			return true;
		}
		return false;
	}
}