<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-6
 * Time: 下午9:59
 */

namespace helpers;
use Yii;
use yii\helpers\Json;

class CResponse {

    /**
     * @return \yii\console\Response|\yii\web\Response
     */
    public static function getResponse(){
        return \Yii::$app->response;
    }

    /**
     * @param null $data
     * @param int $status
     * @param string $message
     * @return array
     */
    public static function json($data = null,$status =200,$message = 'Success'){
        $response = static::getResponse();
        $response->format = \yii\web\Response::FORMAT_JSON;
        return static::getOutput($data ,$status ,$message);
    }

    /**
     * @param null $data
     * @param int $status
     * @param string $message
     */
    public static function cjson($data = null,$status=200,$message='Success'){
        header("Content-type: application/json");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description');
        echo Json::encode(static::getOutput($data ,$status ,$message));
        exit;
    }

    /**
     * @param $data
     * @param $status
     * @param $message
     * @return array
     */
    public static function getOutput($data ,$status ,$message){
        $output = [];
        if($data){
            foreach($data as $key => $val){
                $output[$key] = $val;
            }
        }
        if( !isset($output['status'])){
            $output['statusCode'] = $status;
        }
        if( !isset($output['status'])){
            $output['message'] = $message;
        }
        return $output;
    }
} 