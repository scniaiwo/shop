<?php

namespace backend\models\AdminUser;

use backend\models\AdminMenu;
use Yii;
use yii\base\Model;
use   backend\models\AdminUser;
/**
 * This is the model class for table "admin_user".
 *
 * @property int $id
 * @property string   $username
 * @property string   $password
 * @property string   $newPassword
 * @property string   $rePassword
 * @property datetime $created_at
 * @property datetime $updated_at
 */
class AdminUserForm extends AdminUser
{
    public $username;
    public $password;
    public $newPassword;
    public $rePassword;
    public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required','on'=>['login','edit','create']],
            // rememberMe must be a boolean value
//            ['rememberMe', 'boolean'],
            ['password', 'validatePassword','on'=>['login','edit']],
//            [['newPassword','rePassword'],'required','on'=>['changePassword']],
//            ['newPassword','validateRePassword','on'=>['changePassword']]
        ];
    }

    /**
     * Validate the Duplicate password
     *
     * @param $attribute
     * @param $params
     */
    public function validateRePassword($attribute, $params){
        if (!$this->hasErrors()) {
            if ($this->newPassword !== $this->rePassword) {
                $this->addError($attribute, ' Duplicate password error.');
            }
        }
    }

    /**
     * @param $attribute
     * @param $params
     * @return bool|void
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->checkPassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(),0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = AdminUser::findByUsername($this->username);
        }
        return $this->_user;
    }

    public function save($runValidation = true, $attributeNames = null){
        if( $this->id ){
            $this->updated_at = date('Y-m-d H:i:s');
        }else{
            $this->updated_at = date('Y-m-d H:i:s');
            $this->created_at = date('Y-m-d H:i:s');
            $this->password   = md5($this->newPassword);
        }
        return parent::save($runValidation,$attributeNames);
    }
}
