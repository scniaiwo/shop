<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:59
 */

namespace helpers;
use Yii;
use yii\helpers\Url;

class CArray {

    /**
     * Get all values of attribute
     * @param array $arr
     * @param $attribute
     * @return array
     */
    public static function getColumn(array $arr,$attribute){
        $column=array();
        foreach($arr as $one){
            if(is_array($one)){
                $column[]=$one[$attribute];
            }else{
                $column[]=$one->{$attribute};
            }
        }
        return $column;
    }

    /**
     * Removes duplicate values from an array
     * @param array $arr
     * @return array
     */
    public static function unique(array $arr){
        return array_unique($arr);
    }
}