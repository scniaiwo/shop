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
            return static::getRequest()->get($key);
        }
        return static::getRequest()->get();

    }

    /**
     * Return POST parameter  with a given name. If name isn't specified,returns  an array of all POST parameters.
     * @param null $key
     * @return array|mixed
     */
    public static function post($key = null){
        if($key){
            return static::getRequest()->post($key);
        }else{
            return static::getRequest()->post();
        }
    }

    /**
     * If name is specified,prior return POST parameter . If name isn't specified,returns an array of all  parameters.
     * @param null $key
     * @return array|null
     */
    public static function param($key = null){
        $get = static::get();
        $post = static::post();
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

    /**
     * string the name of the token used to prevent CSRF.
     *
     * @return mixed|string
     */
    public static function getCsrfName(){
        return static::getRequest()->csrfParam;
    }

    /**
     * The token used to perform CSRF validation.
     *
     * @return mixed|string
     */
    public static function getCsrfToken(){
        return static::getRequest()->csrfToken;
    }

    /**
     * Get input used to CSRF validation.
     */
    public static function getCsrfHtml(){
        echo CHtml::getCsrf(static::getCsrfName(),static::getCsrfToken());
    }
} 