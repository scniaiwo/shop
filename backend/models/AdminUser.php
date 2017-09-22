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
        return $this->password == md5($password);
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
     * @return  object || null.
     */
    public static function create($args){
        $model = new static();
        if($model->load($args) && $model->save()){
            return $model;
        }
        return null;
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

}
