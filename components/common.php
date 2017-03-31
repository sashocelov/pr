<?php
namespace app\components;
use Yii;
use app\models\Weather;
use app\models\User;

class common {
    public static function getOwner($strParam = '') {
        $pUser = User::findIdentity(Yii::$app->user->id);
        if ($pUser !== null) {
            switch ($strParam) {
                case 'group':
                    return 'G:'.$pUser->groupId.':';
                default:
                    return 'G:'.$pUser->groupId.':-ID:'.$pUser->id;
            }
        } else {
            die('User error !');
        }
        
    }

    public static function setAuthState($strTitle, $pGroup) {
        Yii::$app->session->set($strTitle, serialize($pGroup));
    }

    public static function getAuthState($strTitle, $strParam='') {
        $strVal = Yii::$app->session->get($strTitle);
        if (!empty($strVal)) {
            $strVal = unserialize($strVal);
            if (!empty($strParam) && isset($strVal[$strParam])) {
                return $strVal[$strParam];
            }
            return $strVal;
        }
        return false;
    }

    public static function clearAuthState($strTitle) {
        Yii::$app->session->set($strTitle, NULL);
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

	public static function mysql_escape_no_conn($input) { 
        if( is_array( $input ) ) {
            return array_map( __METHOD__, $input ); 
        }
        if( !empty( $input ) && is_string( $input ) ) { 
            return str_replace( array( '\\', "\0", "\n", "\r", "'", '"', "\x1a" ), 
                                array( '\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z' ),
                                $input ); 
        } 
        return $input; 
    }

    public static function getCurrentDatetime($bOnlyTime = false) {
        date_default_timezone_set('Europe/Sofia');

        if ($bOnlyTime) {
            return date('H:i:s');
        }
        return date('Y-m-d H:i:s');
    }

    public static function getCurrentDate() {
        return date('Y-m-d');
    }	
}