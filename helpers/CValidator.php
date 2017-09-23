<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-7
 * Time: 下午4:29
 */

namespace helpers;
use yii\base\DynamicModel;
class CValidator {
    /**
     * @param array $data
     * @param array $rules
     * @return DynamicModel
     */
    public static function passes(array $data, $rules = []){
        return DynamicModel::validateData($data, $rules);
    }

    /**
     * Get first error
     *
     * @param $model
     * @return mixed
     */
    public static function getFirstError($model){
        $key = key($model->getFirstErrors());
        return $model->getFirstErrors()[$key];
    }

    /**
     * Get Error
     *
     * @param $model
     * @return mixed
     */
    public static function getError($model){
        return static::getFirstError($model);
    }
}