<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-11
 * Time: 下午1:49
 */

namespace services;
use helpers\CArray;
use services\AbstractService;
use Yii;
use backend\models\AdminUserRole;

class RoleService extends AbstractService {
    /**
     * Returns the static model.
     *
     * @param string $className service class name.
     * @return RoleService
     * @author liupf 2017/9/19
     */
    public static function factory($className = __CLASS__)
    {
        return parent::factory($className);
    }

    /**
     * Get user roles by given userID
     * @param $userID
     * @return array|AdminUserRole[]
     * @author liupf 2017/9/15
     */
    public function getUserRoles($userID){
        return AdminUserRole::find()->asArray()->where([
            'user_id'  => $userID
        ])->all();
    }

    /**
     * Get user role ids by given userID
     *
     * @param $userID
     * @return array
     * @author liupf 2017/9/15
     */
    public function getUserRoleIDs($userID){
        $roles  = $this->getUserRoles($userID);
        return CArray::getColumn($roles,'role_id');
    }

}