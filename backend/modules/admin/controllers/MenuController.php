<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminMenu;
use backend\modules\admin\AdminBaseController;
use helpers\CRequest;
use helpers\CResponse;
use helpers\CValidator;
use services\MenuService;
use services\Test;
use Yii;
/**
 * MenuController controller for the `admin` module
 */
class MenuController extends AdminBaseController
{
    /**
     * Menu manage  view
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionManager()
    {
        return $this->render('manager');
    }

    /**
     * Menu  edit view
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
     * Modify menu
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
     * Menu add view
     *
     * @return string
     * @author liupf 2017/9/16
     */
    public function actionAdd(){
        $createForm = CRequest::param('createForm');

        if( !$createForm ){
            return $this->renderPartial('add');
        }

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
        AdminMenu::deleteByIDs($ids);
        return CResponse::json();
    }

}
