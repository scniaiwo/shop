<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:37
 */
namespace backend\controllers;
use helpers\CUser;
use Yii;
use yii\web\Controller;

class LogoutController  extends Controller {
    public function actionIndex(){
        if(!CUser::isGuest()){
            CUser::logout();
        }
        $this->redirect('/login/index')->send();
    }
}