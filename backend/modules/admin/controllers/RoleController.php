<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminRole;
use backend\modules\admin\AdminBaseController;
use helpers\CHtml;
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
     * Renders the manager view for the module
     * @return string
       * @author liupf 2017/9/21
     */
    public function actionManager()
    {
        $data = CPager::find()->init([
            'obj' => new AdminRole(),
        ])->get();
        return $this->renderPartial('manager',$data);
    }

    /**
     * Edit role view
     *
     * @return string
     * @author liupf 2017/9/23
     */
    public function actionEdit(){
        $id = CRequest::param('id');
        if(empty($id)){
            echo 'id can not empty!';exit;
        }
        $role = AdminRole::findById($id);
        if(!$role){
            echo 'id is not exist!';exit;
        }
        $menuIDs = MenuService::factory()->getActiveRoleMenuIDs([$id]);
        return $this->renderPartial('edit',[
            'role'=>$role,
            'editFieldsHtml' => CHtml::getEditFieldSet(AdminRole::getEditFields(),$role),
            'menuIDs'=>array_flip($menuIDs)
        ]);
    }

    /**
     * modify role
     *
     * @return array
     * @author liupf 2017/9/23
     */
    public function actionModify(){
        $editForm = CRequest::param('editForm');
        if( empty($editForm['id']) || empty($editForm['selectIDs'])){
            return CResponse::json(null,300,' Parameter error!');
        }
        $role = AdminRole::findById($editForm['id']);
        if( empty($role) ){
            return CResponse::json(null,300,'Id is not exist!');
        }
        $adminMenu = AdminRole::updateByModel($role,$editForm);
        if( $adminMenu->getErrors()){
            return CResponse::json(null,300,CValidator::getError($adminMenu));
        }else{
            $selectIDs = explode(',',$editForm['selectIDs']);
            $isSuccess = RoleService::factory()->updateRoleMenus($editForm['id'],$selectIDs);
            return $isSuccess ? CResponse::json(['callbackType'=>'closeCurrent']):
                                CResponse::json(null,300,'Modify Failure!');
        }
    }

    /**
     * delete  role
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
        $isSuccess = AdminRole::updateStatusByIDs($ids,AdminRole::STATUS_DELETE);
        if($isSuccess){
            return CResponse::json();
        }else{
            return CResponse::json(null,300,'Failure!');
        }
    }

    /**
     * Role add
     *
     * @author liupf 2017/9/16
     */
    public function actionAdd(){
        $editForm = CRequest::param('editForm');
        if( !$editForm ){
            return $this->renderPartial('add',[
                'editFieldsHtml' => CHtml::getEditFieldSet(AdminRole::getCreateFields(),null),
            ]);
        }
        $menuIDs    = $editForm['selectIDs'];
        if(empty($menuIDs)){
            return CResponse::json(null,300,'Parameter error!');
        }
        $role = AdminRole::create($editForm);
        if( $role->getErrors() ){
            return CResponse::json(null,300,CValidator::getError($role));
        }else{
            $isSuccess = RoleService::factory()->saveRoleMenus($role->id,explode(',',$menuIDs));
            return $isSuccess ? CResponse::json(['callbackType'=>'closeCurrent']):
                CResponse::json(null,300,'Save Failure');
        }
    }
}
