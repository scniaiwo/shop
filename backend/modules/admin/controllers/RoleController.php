<?php

namespace backend\modules\admin\controllers;

use backend\models\AdminRole;
use backend\modules\admin\AdminBaseController;
use helpers\CPager;
use helpers\CSearch;
use helpers\CUrl;
use services\MenuService;
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
}
