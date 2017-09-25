<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-20
 * Time: 下午2:51
 */

namespace helpers;


class CPager {
    public $_params = [];

    # 默认值
    private  $_pageNum = 1;
    private $_numPerPage = 50;

    # 默认 排序字段 和 排序方式
    private $_sortDirection = 'desc';
    private $_orderField = 'id' ;   # 如果不设置，会默认使用主键排序;

    # 各种operation  url
    private $_operations = [];

    #定义表格显示部分的配置
    private  $_tableFields = [];
    private $_searchFields = [];

    #对象
    /**
     * @var \yii\db\ActiveRecord
     */
    private $_obj;

    /**
     * @return CPager
     */
    public static  function find(){
        return \Yii::createObject(get_class());
    }

    /**
     * init
     * @param $config
     * @return CPager
     */
    public function init($config){
        $this->_obj  = $config['obj'];
        $this->initParams($config);
        $this->initOperations();
        $this->initTableFields();
        $this->initSearchFields();
        return $this;
    }

    /**
     * Init params
     */
    public function initParams($config){
        $param = CRequest::param();
        if(empty($param['pageNum']))    $param['pageNum']    = $this->_pageNum ;
        if(empty($param['numPerPage'])) $param['numPerPage'] = $config['numPerPage']?:$this->_numPerPage ;
        if(empty($param['orderField'])) $param['orderField'] = $config['orderField']?:$this->_orderField ;
        if(empty($param['orderDirection'])) $param['orderDirection'] = $config['orderDirection']?:$this->_sortDirection ;
        $this->_params = array_merge($this->_params, $param) ;
    }

    /**
     * Init table fields
     */
    public function initTableFields(){
        $this->_tableFields = $this->_obj->getTableFields();
    }

    /**
     * Init search fields
     */
    public function initSearchFields(){
        $this->_searchFields = $this->_obj->getSearchFields();
    }

    /**
     * Init operations
     */
    public function initOperations(){
        $operations = $this->_obj->getOperations();
        foreach($operations as $k=>$v){
            $this->_operations[$k] = CUrl::create($v);
        }
    }

    /**
     * @return array
     */
    public function get(){
        return [
            'pagerForm' => $this->getPagerForm(),
            'searchBar' => $this->getSearchBar(),
            'toolBar'   => $this->getToolBar(),
            'tableHead' => $this->getTableHead(),
            'tableBody' => $this->getTableBody(),
            'pagerBar'  => $this->getPagerBar()
        ];
    }

    /**
     * Get pager form
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getPagerForm(){
        $params = $this->_params;
        return CHtml::getPagerForm($params);
    }

    /**
     * Get search bar
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getSearchBar(){
        $searchFields = $this->_searchFields;
        $params = $this->_params;
        return CHtml::getSearchBar($searchFields,$params);
    }

    /**
     * Get tool bar
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getToolBar(){
        $operations = $this->_operations;
        return CHtml::getToolBar($operations);
    }

    /**
     * Get table head
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getTableHead(){
        $tableFields   = $this->_tableFields;
        $orderFiled    = $this->_orderField;
        $orderDirection= $this->_params['orderDirection'];
        $operations    = $this->_operations;
        return CHtml::getTableHead($tableFields,$operations,$orderFiled,$orderDirection);
    }

    /**
     * Get table body
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getTableBody(){
        $data = $this->_getTableData();
        $operations    = $this->_operations;
        $tableFields   = $this->_tableFields;
        return CHtml::getTableBody($data,$tableFields,$operations);
    }

    /**
     * Get table data
     *
     * @return mixed
     * @author liupf 2017/9/21
     */
    private  function _getTableData(){
        $obj = $this->_obj;
        $searchFields = $this->_searchFields;
        $query = $obj::find()->asArray();
        if(is_array($searchFields) && !empty($searchFields)){
            $this->_initWhere($query,$searchFields);
        }
        $this->_params['numCount'] = $query->count();
        $query->limit  = $this->_params['numPerPage'];
        $query->offset = ($this->_params['pageNum'] -1)*$this->_params['numPerPage'] ;
        $query->orderBy([$this->_params['orderField']=> (($this->_params['orderDirection'] == 'desc') ? SORT_DESC : SORT_ASC)]);
        return $query->all();
    }

    /**
     * init where condition
     * @param $query
     * @param $searchFields
     * @author liupf 2017/9/21
     */
    private function _initWhere(&$query,$searchFields){
        foreach($searchFields as $searchField){
            $type = $searchField['type'];
            $name = $searchField['name'];
            $columnsType = isset($field['columnsType']) ? $field['columnsType'] : '';
            if($this->_params[$name] || $this->_params[$name.'_get'] || $this->_params[$name.'_lt']){
                if($type == 'text' || $type == 'select' || $type == 'date'){
                    switch($columnsType){
                        case 'string' : $query->andWhere(['like', $name, $this->_params[$name]]);break;
                        case 'int'    : $query->andWhere([$name => (int)$this->_params[$name]]);break;
                        case 'float'  : $query->andWhere([$name => (float)$this->_params[$name]]);break;
                        default       : $query->andWhere([$name => $this->_params[$name]]);break;
                    }
                }else if($type == 'dateRange'){
                    $_gte 	= $this->_params[$name.'_gte'];
                    $_lt 	= $this->_params[$name.'_lt'];
                    $_gte  && $query->andWhere(['>=', $name, $_gte]);
                    $_lt   && $query->andWhere(['<', $name, $_lt]);
                }else if($type == 'range'){
                    $_gte 	= $this->_params[$name.'_gte'];
                    $_lt 	= $this->_params[$name.'_lt'];
                    if($columnsType == 'int'){
                        $_gte 	= (int)$_gte;
                        $_lt	= (int)$_lt;
                    }else if($columnsType == 'float'){
                        $_gte 	= (float)$_gte;
                        $_lt	= (float)$_lt;
                    }
                    $_gte  && $query->andWhere(['>=', $name, $_gte]);
                    $_lt   && $query->andWhere(['<', $name, $_lt]);
                }else{
                    $query->andWhere([$name => $this->_params[$name]]);
                }
            }
        }
    }

    /**
     * Get pager bar
     *
     * @return string
     * @author liupf 2017/9/21
     */
    public function getPagerBar(){
        $numPerPage = $this->_params['numPerPage'];
        $pageNum = $this->_params['pageNum'];
        $numCount= $this->_params['numCount'];
        return CHtml::getPagerBar($numPerPage,$pageNum,$numCount);
    }

    /**
     * Get  search type by db type
     *
     * @param $type
     * @return string
     * @author liupf 2017/9/22
     */
    public static function getSearchType($type){
        switch($type){
            case 'datetime': $searchType = 'dateRange';break;
            case 'tinyint' : $searchType = 'select';break;
            default        : $searchType = 'text';break;
        }
        return $searchType;
    }

    /**
     * Get  search column type by db type
     *
     * @param $type
     * @return string
     * @author liupf 2017/9/22
     */
    public static function getSearchColumnType($type){
        switch($type){
            case 'datetime'  : $searchColumnType = 'datetime';break;
            case 'tinyint'   :
            case 'smallint'  :
            case 'mediumint' :
            case 'bigint'    :
            case 'integer'   : $searchColumnType = 'int';break;
            case 'float'     : $searchColumnType = 'float';break;
            default          : $searchColumnType = 'string';break;
        }
        return $searchColumnType;
    }
} 