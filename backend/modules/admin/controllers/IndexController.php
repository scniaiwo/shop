<?php

namespace backend\modules\admin\controllers;

use backend\modules\admin\AdminBaseController;
use services\MenuService;
use Yii;
use helpers\CResponse;
/**
 * IndexController controller for the `admin` module
 */
class IndexController extends AdminBaseController
{
      /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = "back_main.php";
        return $this->render('index');
    }

    public function actionTest(){
        $test =  MenuService::factory()->tree(0);
        return CResponse::json($test);
    }
}
