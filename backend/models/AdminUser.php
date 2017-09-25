<?php
namespace backend\models;
use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
/**
 * User model
 *
 * @property integer $id
 * @property string $password
 * @property string $password_md5
 * @property string $username
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */

class AdminUser extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 2;
    const STATUS_ACTIVE  = 1;

    /**
     * @inheritdoc
     */
    # 设置 status  默认  ，以及取值的区间
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }


    public function attributeLabels()
    {
        return [
            'username'	 	=> '用户名',
            'password'      => '密码',
            'created_at' 	=> '创建时间',
            'updated_at' 	=> '更新时间',
            'status'        => '激活状态',

        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin_user';
    }


    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token
     * @param null $type
     * @return void|IdentityInterface
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        exit;
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID
     */
    public function getAuthKey()
    {
        exit;
    }

    /**
     * Validates the given auth key.
     *
     * @param string $authKey
     * @return bool|void
     */
    public function validateAuthKey($authKey)
    {
        exit;
    }
    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Validates the given password
     *
     * @param $password
     * @return bool
     */
    public function checkPassword($password){
        return $this->password == $password && $this->password_md5 == md5($password);
    }

    /**
     * Finds by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return  AdminUser that matches the given ID.
     */
    public static function findById($id)
    {
        return static::findOne(['id' => $id]);
    }
    /**
     * Create a new AdminUser.
     *
     * @param $args
     * @return  AdminUser.
     */
    public static function create($args){
        $model = new AdminUser();
        $model->attributes   = $args;
        $model->created_at   = date('Y-m-d H:i:s');
        $model->updated_at   = date('Y-m-d H:i:s');
        $model->password     = $args['password'];
        $model->password_md5 = md5($args['password']);
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
     * delete AdminUser  by the ids.
     *
     * @param $ids
     * @return bool
     */
    public static function deleteByIDs($ids){
        $numOfDelete =  static::deleteAll(['id'=>$ids]);
        return count($ids) == $numOfDelete ? true:false;
    }
    /**
     * Get Operations
     *
     * @return array.
     */
    public static  function getOperations(){
        return [
            'add'     => [
                'url'    => '/admin/user/add',
                'width'  => 570,
                'height' => 300
            ],
            'edit'    => [
                'url'    => '/admin/user/edit',
                'width'  => 570,
                'height' => 300
            ],
            'delete'  =>[
                'url'    => '/admin/user/delete',
            ],
        ];
    }

    /**
     * Get table fields
     *
     * @return array.
     */
    public static  function getTableFields(){
        return [
            [
                'name'          =>  'id',
                'orderField'    =>  true,
                'label'         =>  '' ,
                'width'         =>  10 ,
                'align'         =>  'left' ,
            ],
            [
                'name'          =>  'username',
                'orderField'    =>  false,
                'label'         =>  '用户名' ,
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
                'values'        =>[
                    AdminUser::STATUS_ACTIVE =>  '正常',
                    AdminUser::STATUS_DELETED => '删除',
                ]
            ],
        ];
    }

    /**
     * Get search fields
     *
     * @return array.
     */
    public static  function getSearchFields(){
        return [
            [
                'type'         =>  'select',
                'title'        =>  '',
                'name'         =>  'status' ,
                'columns_type' =>  'int',
                'values'       =>[
                    ''=>'全部',
                    AdminUser::STATUS_ACTIVE =>  '正常',
                    AdminUser::STATUS_DELETED => '删除',
                ]
            ],
            [
                'type'         =>  'text',
                'title'        =>  '用户名',
                'name'         =>  'username' ,
                'columns_type' =>  'string',
            ],
            [
                'type'         =>  'dateRange',
                'title'        =>  '创建时间',
                'name'         =>  'created_at' ,
                'columns_type' =>  'datetime',
                'values'        =>[
                    '_gte' => '开始时间' ,
                    '_lt' =>  '结束时间'
                ]
            ],
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
                'label'        =>  'ID',
                'name'         =>  'id' ,
                'readonly'     => true,
                'required'     => true
            ],
            [
                'type'         =>  'text',
                'label'        =>  '用户名',
                'name'         =>  'username' ,
                'required'     =>  true
            ],
            [
                'type'         =>  'text',
                'label'        =>  '密码',
                'name'         =>  'password' ,
            ],
            [
                'type'         =>  'select',
                'label'        =>  '状态',
                'name'         =>  'status' ,
                'required'     =>  true,
                'values'       => [
                    AdminUser::STATUS_ACTIVE =>  '正常',
                    AdminUser::STATUS_DELETED => '删除',
                ]
            ],
        ];
    }


    /**
     * Get edit fields
     *
     * @return array.
     */
    public static  function getCreateFields(){
        return [
            [
                'type'         =>  'text',
                'label'        =>  '用户名',
                'name'         =>  'username' ,
                'required'     =>  true
            ],
            [
                'type'         =>  'text',
                'label'        =>  '密码',
                'name'         =>  'password' ,
                'required'     =>  true
            ],
            [
                'type'         =>  'select',
                'label'        =>  '状态',
                'name'         =>  'status' ,
                'required'     =>  true,
                'values'       => [
                    AdminUser::STATUS_ACTIVE =>  '正常',
                    AdminUser::STATUS_DELETED => '删除',
                ]
            ],
        ];
    }
}
