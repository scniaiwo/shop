<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminRole;
use backend\modules\admin\AdminBaseController;
use helpers\CPager;
use helpers\CRequest;
use helpers\CSearch;
use helpers\CUrl;
use helpers\CValidator;
use services\MenuService;
use services\RoleService;
use Yii;
use helpers\CResponse;
/**
 * RoleController controller for the `admin` module
 */
class RoleController extends AdminBaseController
{
      /**
     * Renders the index view for the module
     * @return string
     */
    public function actionManager()
    {
        $data = CPager::find()->init([
            'obj' => new AdminRole(),
        ])->get();
        return $this->renderPartial('manager',$data);
    }

    public function actionEdit(){
        $id = CRequest::param('id');
        if(empty($id)){
            echo 'id can not empty!';exit;
        }
        $role = AdminRole::findById($id);
        if(!$role){
            echo 'id is not exist!';exit;
        }
        return $this->renderPartial('edit',array('role'=>$role));
    }

    public function actionModify(){
        $editForm = CRequest::param('editForm');
        if( empty($editForm['id'])){
            return CResponse::json(null,300,'Id can not empty!');
        }
        $role = AdminRole::findById($editForm['id']);
        if( empty($role) ){
            return CResponse::json(null,300,'Id is not exist!');
        }
        $adminMenu = AdminRole::updateByModel($role,$editForm);
        if( $adminMenu->getErrors()){
            return CResponse::json(null,300,CValidator::getError($adminMenu));
        }else{
            return CResponse::json();
        }
    }

    public function actionDelete(){
        $ids = CRequest::param('ids');
        if(empty($ids)){
            return CResponse::json(null,300,'Id can  not empty!');
        }
        $ids = explode(',',$ids);
        $isSuccess = AdminRole::deleteAdminRoleByIDs($ids);
        if($isSuccess){
            RoleService::factory()->deleteRoleMenus($ids);
            return CResponse::json();
        }else{
            return CResponse::json(null,300,'Failure!');
        }
    }

    /**
     * Role add page
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionAdd(){
        return $this->renderPartial('add');
    }

    /**
     * Save a new role
     *
     * @return array
     * @author liupf 2017/9/16
     */
    public function actionSave(){
        $createForm = CRequest::param('createForm');
        $menuIDs    = $createForm['menuIDs'];
        if(empty($menuIDs)){
            return CResponse::json(null,300,'参数错误');
        }
        $role = AdminRole::create($createForm);
        if( $role->getErrors() ){
            return CResponse::json(null,300,CValidator::getError($role));
        }else{
            $isSuccess = RoleService::factory()->saveRoleMenus($role->id,substr($menuIDs,0,-1));
            return $isSuccess ? CResponse::json(['callbackType'=>'closeCurrent']):
                CResponse::json(null,300,'保存菜单失败');
        }
    }
}
