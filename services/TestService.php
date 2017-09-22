<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-19
 * Time: 下午1:55
 */

namespace services;


use backend\models\AdminMenu;

class TestService extends AbstractService {
    /**
     * Returns the static model.
     *
     * @param string $className service class name.
     * @return TestService
     * @author liupf 2016/10/24
     */
    public static function factory($className = __CLASS__)
    {
        return parent::factory($className);
    }
    public function actionGetTest(){
        AdminMenu::deleteById(1);
    }
} 