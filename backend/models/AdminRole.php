<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin_role".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 */
class AdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
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
            'description' => 'Description',
        ];
    }
    /**
    * Finds by the given ID.
    *
    * @param string|int $id the ID to be looked for
    * @return  AdminRole || null.
    */
    public static function findById($id)
    {
         return static::findOne(['id' => $id]);
    }
    /**
    * Create a new AdminRole.
    *
    * @param $args
    * @return  AdminRole.
    */
    public static function create($args){
        $model = new AdminRole();
        $model->attributes = $args;
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
     * Update  by the model.
     *
     * @param $model
     * @param $args
     * @return AdminRole.
     */
    public static function updateByModel($model,$args){
        $model->attributes = $args;
        $model->save();
        return $model;
    }

    /**
     * delete AdminRole  by the ids.
     *
     * @param $ids
     * @return bool
     */
    public static function deleteAdminRoleByIDs($ids){
        $numOfDelete =  static::deleteAll(['id'=>$ids]);
        return count($ids) == $numOfDelete ? true:false;
    }
    /**
     * Get Operations
     *
     * @return array.
     */
    public function getOperations(){
        return [
            'edit'    => '/admin/role/edit',
            'delete'  => '/admin/role/delete',
            'add'     => '/admin/role/add',
        ];
    }

    /**
     * Get table fields
     *
     * @return array.
     */
    public function getTableFields(){
        return [
            [
                'name'          =>  'id',
                'orderField'    =>  true,
                'label'         =>  'ID' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
            [
                'name'          =>  'name',
                'orderField'    =>   false,
                'label'         =>  '权限名字' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
            [
                'name'          =>  'description',
                'orderField'    =>  false,
                'label'         =>  '权限描述' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
        ];
    }

    /**
     * Get search fields
     *
     * @return array.
     */
    public function getSearchFields(){
        return [
            [
                'type'         =>  'text',
                'title'        =>  '权限名称',
                'name'         =>  'name' ,
                'columns_type' =>  'string',
            ],
        ];
    }
}
