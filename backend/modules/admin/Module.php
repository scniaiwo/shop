<?php

namespace backend\modules\admin;

/**
 * admin module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'backend\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->layout = "back_ajax.php";
        parent::init();

        // custom initialization code goes here
    }
}
