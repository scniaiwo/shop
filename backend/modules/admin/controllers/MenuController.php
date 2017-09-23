<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminMenu;
use backend\models\AdminRoleMenu;
use backend\modules\admin\AdminBaseController;
use helpers\CRequest;
use helpers\CResponse;
use helpers\CUrl;
use helpers\CValidator;
use services\MenuService;
use services\Test;
use Yii;
use yii\web\Controller;
/**
 * MenuController controller for the `admin` module
 */
class MenuController extends AdminBaseController
{
    /**
     * Menu manage  page
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionManager()
    {
        return $this->render('manager');
    }

    /**
     * Menu  modify page
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionEdit(){
        $id = CRequest::param('id');
        if(empty($id)){
            echo 'id can not empty!';exit;
        }
        $adminMenu = AdminMenu::findById($id);
        if(!$adminMenu){
            echo 'id is not exist!';exit;
        }
        return $this->renderPartial('edit',array('menu'=>$adminMenu));
    }

    /**
     * Edit menu
     *
     * @return array
     * @author liupf 2017/9/16
     */
    public function actionModify(){
        $editForm = CRequest::param('editForm');
        if( empty($editForm['id'])){
            return CResponse::json(null,300,'Id can not empty!');
        }
        $adminMenu = AdminMenu::findById($editForm['id']);
        if( empty($adminMenu) ){
            return CResponse::json(null,300,'Id is not exist!');
        }
        $adminMenu = AdminMenu::updateByModel($adminMenu,$editForm);
        if( $adminMenu->getErrors()){
            return CResponse::json(null,300,CValidator::getError($adminMenu));
        }else{
            return CResponse::json();
        }
    }

    /**
     * Menu add page
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionAdd(){
        return $this->renderPartial('add');
    }

    /**
     * Save a new menu
     *
     * @return array
     * @author liupf 2017/9/16
     */
    public function actionSave(){
        $createForm = CRequest::param('createForm');
        $adminMenu = AdminMenu::create($createForm);
        if( $adminMenu->getErrors() ){
            return CResponse::json(null,300,CValidator::getError($adminMenu));
        }else{
            return CResponse::json(['callbackType'=>'closeCurrent']);
        }
    }

    /**
     * Delete menu  by parent node id
     * @return array
     * @author liupf 2017/9/16
     */
    public function actionDelete(){
        $id = CRequest::param('id');
        if(empty($id)){
            return CResponse::json(null,300,'Id can  not empty!');
        }
        $ids = MenuService::factory()->getSubTreeNodeIds($id);
        AdminMenu::deleteAdminMenuByIDs($ids);
        return CResponse::json();
    }

}
