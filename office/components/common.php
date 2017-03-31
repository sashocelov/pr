<?php
namespace app\components;
use Yii;
use app\models\Weather;
use app\models\User;

class common {
    public static function getUserId() {
        return \Yii::$app->user->getId();
    }

	public static function getDate($strFormat, $strTime) {
        $date=date($strFormat, strtotime($strTime)); 
        $array1=array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"); 
        $array2=array("Понеделник", "Вторник", "Сряда", "Четвъртък", "Петък", "Събота", "Неделя"); 
        $array3=array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"); 
        $array4=array("Януари", "Февруари", "Март", "Април", "Май", "Юни", "Юли", "Август", "Септември", "Октомври", "Ноември", "Декември"); 

        $date1=str_replace($array1,$array2,$date); 
        $date2=str_replace($array3,$array4,$date1);
        return $date2;
	}

    public static function getCurrentDate() {
        return date('Y-m-d');
    }	
}