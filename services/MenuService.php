<?php
namespace services;
use helpers\CArray;
use helpers\CResponse;
use helpers\CUser;
use services\AbstractService;
use Yii;
use backend\models\AdminRoleMenu;
use backend\models\AdminMenu;

class MenuService extends AbstractService {
    /**
     * Returns the static model.
     *
     * @param string $className service class name.
     * @return MenuService
     * @author liupf 2017/9/16
     */
    public static function factory($className = __CLASS__)
    {
        return parent::factory($className);
    }

    /**
     * Get  Menus by given roleIDs
     *
     * @param $roleIDs
     * @return array|AdminRoleMenu[]
     * @author liupf 2017/9/16
     */
    public function getRoleMenus($roleIDs){
        return AdminRoleMenu::find()->asArray()->where([
            'in','role_id',$roleIDs
        ])->all();
    }

    /**
     * Get Active menuIDs by  given roleIDs
     *
     * @param $roleIDs
     * @return array
     * @author liupf 2017/9/16
     */
    public function getActiveRoleMenuIDs($roleIDs){
        $roleMenus  = $this->getRoleMenus($roleIDs);
        return CArray::unique(CArray::getColumn($roleMenus,'menu_id'));
    }

    /**
     * Get user menu
     *
     * @return array
     * @author liupf 2017/9/16
     */
    public function getUserMenu(){
        $userID  = CUser::getUser()->identity->getId();
        $roleIDs = RoleService::factory()->getUserRoleIDs($userID);
        $menuIDs = $this->getActiveRoleMenuIDs($roleIDs);
        $tree = $this->tree(0);
        return $this->_getActiveUserMenuTree($tree,$menuIDs);
    }

    /**
     * Get active menu tree
     *
     * @param $tree
     * @param $menuIDs
     * @return array
     * @author liupf 2017/9/16
     */
    private  function _getActiveUserMenuTree($tree,$menuIDs){
        $menu = [];
        foreach($tree as $node){
            if(in_array($node['id'],$menuIDs)){
                $name = $node["name"];
                $id   = $node["id"];
                $urlKey = $node["url_key"];
                $menu[$id] = [
                    'id' 		=> $id,
                    'name' 		=> $name,
                    'url_key' 	=> $urlKey,
                ];
                $menu[$id]['child'] = $this->_getActiveUserMenuTree($node['child'],$menuIDs);
            }
        }
        return $menu;
    }

    /**
     * Get Menu tree by given  parentID
     * @param $parentID
     * @return array
     * @author liupf 2017/9/16
     */
    public function tree($parentID){
        $menu = [];
        $parents = AdminMenu::find()->asArray()
            ->where(['parent_id' => $parentID])
            ->orderBy(['sort_order' => SORT_DESC])
            ->all();
        if(is_array($parents) && !empty($parents)){
            foreach($parents as $node){
                $name = $node["name"];
                $id   = $node["id"];
                $urlKey = $node["url_key"];
                $menu[$id] = [
                    'id' 		=> $id,
                    'name' 		=> $name,
                    'url_key' 	=> $urlKey,
                ];
                $menu[$id]['child'] = $this->tree($id);
            }
        }
        return $menu;
    }

    /**
     * Get role key by given  user key
     *
     * @param $userKey
     * @return string
     * @author liupf 2017/9/16
     */
    public function getRoleKey($userKey){
        if($userKey){
            $urlKeyPieces = explode("/",$userKey);
            unset($urlKeyPieces[count($userKey)-1]);
            if(!empty($urlKeyPieces)){
                return implode("/",$urlKeyPieces);
            }
        }
        return '';
    }

    /**
     * Get menu level by given parentID
     *
     * @param $parentID
     * @return int
     * @author liupf 2017/9/16
     */
    public function getLevel($parentID){
        if(empty($parentID)){
            return 1;
        }
        $adminUser = AdminMenu::findById($parentID);
        return (int)$adminUser->level + 1;
    }

    /**
     * Get  sort order by  given parentID
     * @param $parentID
     * @return int|mixed
     */
    public function getSortOrder($parentID){
       $adminMenu = AdminMenu::find()->where(['parent_id' => $parentID])
           ->orderBy(['sort_order' => SORT_DESC])
           ->one();
       return $adminMenu ? $adminMenu->sort_order + 1 : 0;
    }

    /**
     * Get sub tree nodeIDs  by given  parent  nodeID
     *
     * @param $parentID
     * @return array
     * @author liupf 2017/9/16
     */
    public function getSubTreeNodeIDs($parentID){
        $nodeIds = [$parentID];
        $parents = AdminMenu::find()->asArray()
            ->where(['parent_id' => $parentID])
            ->all();
        if(is_array($parents) && !empty($parents)){
            foreach($parents as $node){
                $childNodeIds = $this->getSubTreeNodeIDs($node['id']);
                $nodeIds = array_merge($nodeIds,$childNodeIds);
            }
        }
        return $nodeIds;
    }

    /**
     * Menu can delete
     * @param $id
     * @return bool
     * @author liupf 2017/9/16
     */
    public function canDelete($id){
        $adminMenu = AdminMenu::findById($id);
        if( empty($adminMenu) ){
            return false;
        }
        return $adminMenu->can_delete == AdminMenu::$CAN_DELETE ? true : false;
    }
}