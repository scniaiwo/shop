<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:59
 */

namespace helpers;
use Yii;

class CRequest {
    public static function getRequest(){
        return Yii::$app->request;
    }

    /**
     * Return GET parameter  with a given name. If name isn't specified,returns  an array of all GET parameters.
     * @param null $key
     * @return array|mixed
     */
    public static function get($key = null){
        if($key){
            return self::getRequest()->get($key);
        }
        return self::getRequest()->get();

    }

    /**
     * Return POST parameter  with a given name. If name isn't specified,returns  an array of all POST parameters.
     * @param null $key
     * @return array|mixed
     */
    public static function post($key = null){
        if($key){
            return self::getRequest()->post($key);
        }else{
            return self::getRequest()->post();
        }
    }

    /**
     * If name is specified,prior return POST parameter . If name isn't specified,returns an array of all  parameters.
     * @param null $key
     * @return array|null
     */
    public static function param($key = null){
        $get = self::get();
        $post = self::post();
        if($key){
            if(isset($post[$key])){
                return $post[$key] ;
            }else if(isset($get[$key])){
                return $get[$key] ;
            }else{
                return null;
            }
        }else{
            return array_merge($get,$post);
        }
    }
} 