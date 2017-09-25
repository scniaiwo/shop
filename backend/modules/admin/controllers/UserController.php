<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminUser;
use backend\modules\admin\AdminBaseController;
use helpers\CHtml;
use helpers\CPager;
use helpers\CRequest;
use helpers\CResponse;
use helpers\CUser;
use helpers\CValidator;
use services\RoleService;
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

    /**
     * Change password
     * @return array
     */
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


    /**
     * Manager admin user
     * @return string
     * @author liupf 2017/9/25
     */
    public function actionManager()
    {
        $data = CPager::find()->init([
            'obj' => new AdminUser(),
        ])->get();
        return $this->renderPartial('manager',$data);
    }

    /**
     * Add user
     *
     * @return string
     * @author liupf 2017/9/25
     */
    public function actionAdd(){
        return $this->renderPartial('add',[
            'editFieldsHtml' => CHtml::getEditFieldSet(AdminUser::getCreateFields(),null),
            'roles'   => RoleService::factory()->getAllRole(),
        ]);
    }

    /**
     * Save usr
     *
     * @return array
     *  @author liupf 2017/9/25
     */
    public function actionSave(){
        $editForm = CRequest::param('editForm');
        $roleIDs = CRequest::param('roleIDs');
        if(empty($roleIDs)){
            return CResponse::json(null,300,'Parameter error!');
        }
        $user = AdminUser::create($editForm);
        if( $user->getErrors() ){
            return CResponse::json(null,300,CValidator::getError($user));
        }else{
            $isSuccess = RoleService::factory()->saveUserRoles($user->id,$roleIDs);
            return $isSuccess ? CResponse::json(['callbackType'=>'closeCurrent']):
                CResponse::json(null,300,'Save Failure');
        }
    }

    /**
     * Delete  user
     *
     * @return array
     * @author liupf 2017/9/23
     */
    public function actionDelete(){
        $ids = CRequest::param('ids');
        if(empty($ids)){
            return CResponse::json(null,300,'Id can  not empty!');
        }
        $ids = explode(',',$ids);
        $isSuccess = AdminUser::deleteByIDs($ids);
        if($isSuccess){
            RoleService::factory()->deleteUserRoles($ids);
            return CResponse::json();
        }else{
            return CResponse::json(null,300,'Failure!');
        }
    }

    /**
     * Edit user
     *
     * @return string
     */
    public function actionEdit(){
        $id = CRequest::param('id');
        if(empty($id)){
            echo 'id can not empty!';exit;
        }
        $user = AdminUser::findById($id);
        if(!$user){
            echo 'id is not exist!';exit;
        }
        return $this->renderPartial('edit',[
            'editFieldsHtml' => CHtml::getEditFieldSet(AdminUser::getEditFields(),$user),
            'roles'    => RoleService::factory()->getAllRole(),
            'cRoleIDs' => RoleService::factory()->getUserRoleIDs($id)
        ]);
    }


    /**
     * Modify role
     *
     * @return array
     * @author liupf 2017/9/23
     */
    public function actionModify(){
        $editForm = CRequest::param('editForm');
        $roleIDs  = CRequest::param('roleIDs');
        if( empty($editForm['id']) || empty($roleIDs)){
            return CResponse::json(null,300,' Parameter error!');
        }

        $user = AdminUser::findById($editForm['id']);
        if( empty($user) ){
            return CResponse::json(null,300,'Id is not exist!');
        }
        $editForm['password_md5'] = md5($editForm['password']);
        $user = AdminUser::updateByModel($user,$editForm);
        if( $user->getErrors()){
            return CResponse::json(null,300,CValidator::getError($user));
        }else{
            $roleIDs =is_array($roleIDs) ? $roleIDs:[$roleIDs];
            $isSuccess = RoleService::factory()->updateUserRoles($editForm['id'],$roleIDs);
            return $isSuccess ? CResponse::json(['callbackType'=>'closeCurrent']):
                CResponse::json(null,300,'Modify Failure!');
        }
    }

}
