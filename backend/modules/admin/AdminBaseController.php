<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-19
 * Time: 上午9:06
 */

namespace backend\modules\admin;


use helpers\CRequest;
use helpers\CResponse;
use helpers\CUrl;
use yii\web\Controller;

class AdminBaseController extends Controller {
    public function __construct($id, $module, $config = []){
        if(\Yii::$app->user->isGuest){
            $isAjax = CRequest::getRequest()->isAjax;
            if( $isAjax ){
                CResponse::cjson(null,301,'请先登录!');
            }else{
                CUrl::redirect('/login/index');
            }
        }
        parent::__construct($id, $module, $config);
    }

    /**
     *  Authorization verification
     *
     * @param \yii\base\Action $action
     * @return bool
     */
    public function beforeAction($action)
    {
        parent::beforeAction($action);
        return true;
    }

    public function initParam(){
        $param = CRequest::param();
        if(empty($param['pageNum']))  	$param['pageNum'] = $this->_pageNum ;
        if(empty($param['numPerPage'])) $param['numPerPage'] = $this->_numPerPage ;
        if(empty($param['orderField'])) $param['orderField'] = $this->_orderField ;
        if(empty($param['orderField'])) $param['orderField'] = $this->_paramKey ;
        if(empty($param['orderDirection'])) $param['orderDirection'] = $this->_sortDirection ;
        if(is_array($param) && !empty($param)){
            $this->_param = array_merge($this->_param, $param) ;
        }
        $this->_currentUrl 		= CUrl::getCurrentUrlNoParam();
        $this->_currentParamUrl = CUrl::getCurrentUrl();
        $this->_addUrl = $this->_addUrl ? $this->_addUrl : $this->_currentUrl;
        $this->_editUrl = $this->_editUrl ? $this->_editUrl : $this->_currentUrl;
        $this->_deleteUrl = $this->_deleteUrl ? $this->_deleteUrl : $this->_currentUrl;
    }
}