<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-11
 * Time: 下午1:49
 */

namespace services;
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
     * 保存角色菜单
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
     * 删除角色菜单
     * @param $roleIDs
     * @return int
     * @author liupf 2017/9/23
     */
    public function deleteRoleMenus($roleIDs){
        return AdminRoleMenu::deleteAll(['role_id'=>$roleIDs]);
    }

    /**
     * 修改角色菜单
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
}