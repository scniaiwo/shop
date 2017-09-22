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

class CUrl {
    /**
     * Creates a URL based on the given parameters.
     * @param string $url
     * @param bool $scheme
     * @return string
     */
    public static function create($url = '',$scheme = false){
        return Url::to($url,$scheme);
    }

    /**
     * Get the homepage URL
     * @return string
     */
    public static function getHomeUrl(){
        return Yii::$app->getHomeUrl();
    }

    public static function getCurrentUrl(){
        return Url::current();
    }

    public static function redirect($url,$params = []){
        if($url){
            if(substr($url,0,4) != "http"){
                $url = static::create($url,true);
            }
            if(!empty($params) && is_array($params)){
                $arr = [];
                foreach($params as $k=>$v){
                    $arr[] = $k."=".$v;
                }
                return $url.'?'.implode('&',$arr);
            }
            header("Location: $url");
            exit;
        }
    }

}