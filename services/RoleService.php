<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-11
 * Time: 下午1:49
 */

namespace services;
use backend\models\AdminRole;
use backend\models\AdminRoleMenu;
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

    /**
     * Save role menus
     *
     * @param $roleID
     * @param $menuIDs
     * @return bool
     * @author liupf 2017/9/23
     */
    public function saveRoleMenus($roleID,$menuIDs){
        $numOfSave = 0;
        foreach($menuIDs as $menuID){
            $adminRoleMenu = AdminRoleMenu::create(['role_id'=>$roleID,'menu_id'=>$menuID]);
            $adminRoleMenu->id >0 && $numOfSave++;
        }
        return $numOfSave == count($menuIDs) ? true:false;
    }

    /**
     * Delete role menus
     *
     * @param $roleIDs
     * @return int
     * @author liupf 2017/9/23
     */
    public function deleteRoleMenus($roleIDs){
        return AdminRoleMenu::deleteAll(['role_id'=>$roleIDs]);
    }

    /**
     * Update role menus
     *
     * @param $roleID
     * @param $newMenuIDs
     * @return bool
     * @author liupf 2017/9/23
     */
    public function updateRoleMenus($roleID,$newMenuIDs){
        $oldMenuIDs    = MenuService::factory()->getActiveRoleMenuIDs([$roleID]);
        $addMenuIDs    = array_diff($newMenuIDs,$oldMenuIDs);
        $deleteMenuIDs = array_diff($oldMenuIDs,$newMenuIDs);
        $saveSuccess = $this->saveRoleMenus($roleID,$addMenuIDs);
        if($deleteMenuIDs){
            $numberOfDelete = AdminRoleMenu::deleteAll(['role_id'=>$roleID,'menu_id'=>$deleteMenuIDs]);
        }
        return ($saveSuccess && count($deleteMenuIDs) == (int)$numberOfDelete)? true:false;
    }

    /**
     * Get all role
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getAllRole(){
        return AdminRole::find()->asArray()->all();
    }

    /**
     * Save user roles
     *
     * @param $userID
     * @param $roleIDs
     * @return bool
     * @author liupf 2017/9/23
     */
    public function saveUserRoles($userID,$roleIDs){
        $numOfSave = 0;
        foreach($roleIDs as $roleID){
            $adminUserRole = AdminUserRole::create(['user_id'=>$userID,'role_id'=>$roleID]);
            $adminUserRole->id >0 && $numOfSave++;
        }
        return $numOfSave == count($roleIDs) ? true:false;
    }

    /**
     * Delete user roles
     *
     * @param $userIDs
     * @return int
     * @author liupf 2017/9/25
     */
    public function deleteUserRoles($userIDs){
        return AdminUserRole::deleteAll(['user_id'=>$userIDs]);
    }

    /**
     * Update user roles
     *
     * @param $userID
     * @param $newRoles
     * @return bool
     * @author liupf 2017/9/25
     */
    public function updateUserRoles($userID,$newRoles){
        $oldRoleIDs = RoleService::factory()->getUserRoleIDs($userID);
        $addRoleIDs = array_diff($newRoles,$oldRoleIDs);
        $deleteRoleIDs = array_diff($oldRoleIDs,$newRoles);
        $saveSuccess = $this->saveUserRoles($userID,$addRoleIDs);
        if($deleteRoleIDs){
            $numberOfDelete = AdminUserRole::deleteAll(['user_id'=>$userID,'role_id'=>$deleteRoleIDs]);
        }
        return ($saveSuccess && count($deleteRoleIDs) == (int)$numberOfDelete)? true:false;
    }
}