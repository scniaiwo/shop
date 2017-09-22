<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:59
 */

namespace helpers;
use Yii;

class CUser {
    /**
     * The user component.
     * @return mixed|\yii\web\User
     */
    public static function getUser(){
        return Yii::$app->user;
    }

    /**
     * Whether the current user is a guest
     * @return bool
     */
    public static function isGuest(){
        return static::getUser()->isGuest;
    }

    /**
     *  Logs out the current user.
     *  @return bool
     */
    public static function logout(){
        return static::getUser()->logout();
    }
}