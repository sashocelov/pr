<?php
namespace app\components;
use Yii;
use yii\web\Controller;
use app\components\common;


class SVController extends Controller {
	public function __construct($id, $module, $config = [])
	{
	    parent::__construct($id, $module, $config);
	}
}