<?php

namespace backend\models;

use services\MenuService;
use Yii;

/**
 * This is the model class for table "admin_menu".
 * @property string $id
 * @property string $name
 * @property string $sort_order
 * @property string $created_at
 * @property string $updated_at
 * @property string $can_delete
 * @property string $role_key
 * @property string $url_key
 * @property string $parent_id
 * @property string $level
 * */
class AdminMenu extends \yii\db\ActiveRecord
{
    public static $CAN_DELETE = 2;
    public static $CAN_NOT_DELETE = 1;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'parent_id','url_key','role_key','sort_order'], 'required'],
            [['level', 'parent_id', 'sort_order', 'can_delete'], 'number'],
            [['name'], 'string', 'max' => 150],
            [['url_key', 'role_key'], 'string', 'max' => 255],
            [['created_at','updated_at'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'level' => 'Level',
            'parent_id' => 'Parent ID',
            'url_key' => 'Url Key',
            'role_key' => 'Role Key',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sort_order' => 'Sort Order',
            'can_delete' => 'Can Delete',
        ];
    }
    /**
    * Finds by the given ID.
    *
    * @param string|int $id the ID to be looked for
    * @return  AdminMenu || null.
    */
    public static function findById($id)
    {
         return static::findOne(['id' => $id]);
    }
    /**
    * Create a new AdminMenu.
    *
    * @param $args
    * @return  AdminMenu || null.
    */
    public static function create($args){
        $args['level']      = MenuService::factory()->getLevel($args['parent_id']);
        $args['role_key']   = MenuService::factory()->getRoleKey($args['url_key']);
        $args['sort_order'] = MenuService::factory()->getSortOrder($args['url_key']);
        $args['created_at'] = date('Y:m:d H:i:s');
        $args['updated_at'] = date('Y:m:d H:i:s');
        $args['can_delete'] = static::$CAN_DELETE;
        $model = new AdminMenu();
        $model->attributes = $args;
        $model->save();
        return $model;
    }
    /**
    * Update  by the given ID.
    *
    * @param $id
    * @param $args
    * @return AdminMenu.
    */
    public static function updateById($id,$args){
        $args['role_key'] = MenuService::factory()->getRoleKey($args['url_key']);;
        $model = static::findById($id);
        if ($model && $model->load($args) && $model->save()) {
            return  true;
        }
        return false;
    }

    /**
    * Delete  by the given ID.
    *
    * @param $id
    * @return bool.
    */
    public static function deleteById($id){
    $model = static::findById($id);
    if ( $model &&  $model->delete() === 1) {
         return  true;
    }
        return false;
    }

    /**
     * Update  by the model.
     *
     * @param $model
     * @param $args
     * @return AdminMenu.
     */
    public static function updateByModel($model,$args){
        $args['role_key'] = MenuService::factory()->getRoleKey($args['url_key']);
        $model->attributes = $args;
        $model->save();
        return $model;
    }
}
