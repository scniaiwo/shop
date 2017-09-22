<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:37
 */
namespace backend\controllers;
use backend\models\AdminUser\AdminUserForm;
use helpers\CResponse;
use Yii;
use helpers\CUser;
use yii\web\Controller;
use helpers\CRequest;

class LoginController  extends Controller {
    public function actionIndex(){
        if( !CUser::isGuest()){
            $this->redirect('/admin/index/index')->send();
        }
        $loginForm = CRequest::param('login');
        if($loginForm){
            $adminUserForm = new AdminUserForm();
            $adminUserForm->setScenario('login');
            $adminUserForm->attributes = $loginForm;
            if($adminUserForm->login()){
                $this->redirect('/admin/index/index')->send();
            }
        }
       return $this->renderPartial('index');
    }

    public function actionDialog(){
        if( !CUser::isGuest()){
            CResponse::cjson();
        }
        $loginForm = CRequest::param('login');
        if($loginForm){
            $adminUserForm = new AdminUserForm();
            $adminUserForm->setScenario('login');
            $adminUserForm->attributes = $loginForm;
            if($adminUserForm->login()){
                return CResponse::json(['callbackType'=>'closeCurrent'],200,'登录成功!');
            }else{
                return CResponse::json(null,301,'账号或者密码错误!');
            }
        }
        return $this->renderPartial('dialog');
    }
}