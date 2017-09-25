<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminUser;
use backend\modules\admin\AdminBaseController;
use helpers\CRequest;
use helpers\CResponse;
use helpers\CUser;
use helpers\CValidator;
use Yii;
/**
 * UserController controller for the `admin` module
 */
class UserController extends AdminBaseController
{
      /**
     * My account view
     * @return string
     */
    public function actionMyAccount()
    {
        $id = CUser::getUser()->getId();
        $user = AdminUser::findById($id);
        return $this->render('my_account',[
            'name'=>$user->username
        ]);
    }

    public function actionChangePassword(){
        $id = CUser::getUser()->getId();
        $user = AdminUser::findById($id);
        $passwordForm = CRequest::param('passwordForm');
        if( !$user->checkPassword($passwordForm['password']) ){
           return CResponse::json(null,300,'Old password error!');
        }
        if( !$passwordForm['newPassword'] || !$passwordForm['rePassword']){
            return CResponse::json(null,300,'Parameters error!');
        }
        if( $passwordForm['newPassword'] != $passwordForm['rePassword']){
            return CResponse::json(null,300,'Repeat password error!');
        }
        $user->password = md5($passwordForm['newPassword']);
        if( $user->save()){
            return CResponse::json();
        }else{
            return CResponse::json(null,300,CValidator::getError($user));
        }
    }
}
