<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "admin_role".
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 */
class AdminRole extends \yii\db\ActiveRecord
{
    const STATUS_COMMON = 1;
    const STATUS_DELETE = 2;
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status'     => 'Status'
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
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $model->status     = AdminRole::STATUS_COMMON;
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
        $model->updated_at = date('Y-m-d H:i:s');
        $model->save();
        return $model;
    }

    /**
     * delete AdminRole  by the ids.
     *
     * @param $ids
     * @return bool
     */
    public static function deleteByIDs($ids){
        $numOfDelete =  static::deleteAll(['id'=>$ids]);
        return count($ids) == $numOfDelete ? true:false;
    }

    /**
     * Update AdminRole status by give IDs
     *
     * @param $ids
     * @param $status
     * @return int
     */
    public static function updateStatusByIDs($ids,$status = self::STATUS_COMMON){
        $numberOfUpdate =  static::updateAll(['status'=>$status],['id'=>$ids]);
        return $numberOfUpdate == count($ids);
    }

    /**
     * Get Operations
     *
     * @return array.
     */
    public static  function getOperations(){
        return [
            'add'     => [
                'url'    => '/admin/role/add',
                'width'  => 600,
                'height' => 580
            ],
            'edit'    => [
                'url'    => '/admin/role/edit',
                'width'  => 600,
                'height' => 580
            ],
            'delete'  =>[
                'url'    => '/admin/role/delete',
            ],
        ];
    }

    /**
     * Get table fields
     *
     * @return array.
     */
    public static function getTableFields(){
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
            [
                'name'          =>  'created_at',
                'orderField'    =>  true,
                'label'         =>  '创建时间' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
            [
                'name'          =>  'updated_at',
                'orderField'    =>  true,
                'label'         =>  '更新时间' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
            [
                'name'          =>  'status',
                'orderField'    =>  false,
                'label'         =>  '状态' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
                'values'        => [
                    static::STATUS_COMMON => '正常',
                    static::STATUS_DELETE => '删除',
                ]
            ],
        ];
    }

    /**
     * Get search fields
     *
     * @return array.
     */
    public static function getSearchFields(){
        return [
            [
                'type'         =>  'select',
                'title'        =>  '',
                'name'         =>  'status' ,
                'columns_type' =>  'int',
                'values'       =>[
                    ''=>'全部',
                    static::STATUS_COMMON =>  '正常',
                    static::STATUS_DELETE => '删除',
                ]
            ],
            [
                'type'         =>  'text',
                'title'        =>  '权限名称',
                'name'         =>  'name' ,
                'columns_type' =>  'string',
            ],
            [
                'type'         =>  'dateRange',
                'title'        =>  '创建时间',
                'name'         =>  'name' ,
                'columns_type' =>  'datetime',
                'values'        =>[
                    '_gte' => '开始时间' ,
                    '_lt' =>  '结束时间'
                ]
            ]
        ];
    }
    /**
     * Get edit fields
     *
     * @return array.
     */
    public static  function getEditFields(){
        return [
            [
                'type'         =>  'text',
                'label'        =>  '角色名称',
                'name'         =>  'name' ,
                'required'     =>  true
            ],
            [
                'type'         =>  'text',
                'label'        =>  '描述',
                'name'         =>  'description' ,
            ],
            [
                'type'         =>  'select',
                'label'        =>  '状态',
                'name'         =>  'status' ,
                'required'     =>  true,
                'values'       => [
                    self::STATUS_COMMON =>  '正常',
                    self::STATUS_DELETE => '删除',
                ]
            ],
        ];
    }

    /**
     * Get create fields
     *
     * @return array.
     */
    public static  function getCreateFields(){
        return [
            [
                'type'         =>  'text',
                'label'        =>  '角色名称',
                'name'         =>  'name' ,
                'required'     =>  true
            ],
            [
                'type'         =>  'text',
                'label'        =>  '描述',
                'name'         =>  'description' ,
            ],
            [
                'type'         =>  'select',
                'label'        =>  '状态',
                'name'         =>  'status' ,
                'required'     =>  true,
                'values'       => [
                    self::STATUS_COMMON =>  '正常',
                    self::STATUS_DELETE => '删除',
                ]
            ],
        ];
    }
}
