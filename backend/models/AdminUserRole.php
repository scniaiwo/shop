<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin_user_role".
 *
 * @property string $id
 * @property string $user_id
 * @property string $role_id
 * @property string $created_at
 */
class AdminUserRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'role_id', 'created_at'], 'required'],
            [['user_id', 'role_id'], 'integer'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'role_id' => 'Role ID',
            'created_at' => 'Created At',
        ];
    }
    /**
    * Finds by the given ID.
    *
    * @param string|int $id the ID to be looked for
    * @return  AdminUserRole || null.
    */
    public static function findById($id)
    {
         return static::findOne(['id' => $id]);
    }
    /**
    * Create a new AdminUserRole.
    *
    * @param $args
    * @return  AdminUserRolel.
    */
    public static function create($args){
        $model = new AdminUserRole();
        $model->attributes = $args;
        $model->created_at = date('Y-m-d H:i:s');
        $model->save();
        return $model;
    }
    /**
    * Update  by the given ID.
    *
    * @param $id
    * @param $data
    * @return bool.
    */
    public static function updateById($id,$data){
        $model = static::findById($id);
        if ($model && $model->load($data) && $model->save()) {
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
     * delete AdminUserRole  by the ids.
     *
     * @param $ids
     * @return bool
     */
    public static function deleteByIDs($ids){
        $numOfDelete =  static::deleteAll(['id'=>$ids]);
        return count($ids) == $numOfDelete ? true:false;
    }
}
