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

class CHtml {

    /**
     * Get pager form
     *
     * @param $params
     * @return string
     * @author liupf 2017/9/21
     */
    public static function getPagerForm($params){
        unset($params[CRequest::getCsrfName()]);
        $pagerForm = '';
        $pagerForm.= CRequest::getCsrfHtml();
        foreach($params as $k => $v){
            $pagerForm .='<input type="hidden" name="'.$k.'" value="'.$v.'">';
        }
        return $pagerForm;
    }

    /**
     * Get search bar
     *
     * @param $searchFields
     * @param $params
     * @return string
     * @author liupf 2017/9/21
     */
    public static function getSearchBar($searchFields,$params){
        if(empty($searchFields)) return '';
        $searchBar =  '<ul class="searchContent">';
        foreach($searchFields as $searchField){
            switch($searchField['type']){
                case 'text'      : $temp = static::getSearchText($searchField,$params);break;
                case 'date'      : $temp = static::getSearchDate($searchField,$params);break;
                case 'dateRange' : $temp = static::getSearchDateRange($searchField,$params);break;
                case 'select'    : $temp = static::getSearchSelect($searchField,$params);break;
                case 'range'    : $temp = static::getSearchRange($searchField,$params);break;
                default          : $temp = '';
            }
            $searchBar.=$temp;
        }
        $searchBar.= '</ul>';
        $searchBar.= '<div class="subBar">
                        <ul>
                            <li><div class="buttonActive"><div class="buttonContent"><button type="submit">检索</button></div></div></li>
                        </ul>
		            </div>';
        return $searchBar;
    }

    /**
     * Get search bar text
     *
     * @param $searchField
     * @param $params
     * @return string
     * @author liupf 2017/9/21
     */
    public static function getSearchText($searchField,$params){
        $searchText  = '<li>';
        $searchText .= "<label>{$searchField['title']}：</label>";
        $searchText .= '<input type="text" name="'.$searchField['name'].'" value="'.$params[$searchField['name']].'"/>';
        $searchText .= '</li>';
        return $searchText;
    }

    /**
     * Get search bar date
     *
     * @param $searchField
     * @param $params
     * @return string
     * @author liupf 2017/9/21
     */
    public static function getSearchDate($searchField,$params){
        $searchDate  = '<li>';
        $searchDate .= "<label>{$searchField['title']}：</label>";
        $searchDate .= '<input type="date" name="'.$searchField['name'].'" value="'.$params[$searchField['name']].'" readonly="true"/>';
        $searchDate .= '</li>';
        return $searchDate;
    }

    /**
 * Get search bar date range
 *
 * @param $searchField
 * @param $params
 * @return string
 */
    public static function getSearchDateRange($searchField,$params){
        $searchDateRange = '';
        foreach($searchField['values'] as $k=>$v){
            $searchDateRange .= '<li>';
            $searchDateRange .= "<label>{$v}：</label>";
            $searchDateRange .= '<input type="date" name="'.$searchField['name'].$k.'" value="'.$params[$searchField['name'].$k].'" readonly="true"/>';
            $searchDateRange .= '</li>';
        }
        return  $searchDateRange;
    }

    /**
     * Get search bar date range
     *
     * @param $searchField
     * @param $params
     * @return string
     */
    public static function getSearchRange($searchField,$params){
        $searchDateRange = '';
        foreach($searchField['values'] as $k=>$v){
            $searchDateRange .= '<li>';
            $searchDateRange .= "<label>{$v}：</label>";
            $searchDateRange .= '<input type="text" name="'.$searchField['name'].$k.'" value="'.$params[$searchField['name'].$k].'"/>"';
            $searchDateRange .= '</li>';
        }
        return  $searchDateRange;
    }

    /**
     * Get search bar  select
     *
     * @param $searchField
     * @param $params
     * @return string
     * @author liupf 2017/9/21
     */
    public static function getSearchSelect($searchField,$params){
        $searchSelect = '<select class="combox" name="'.$searchField['name'].'">';
         foreach( $searchField['values'] as $k=>$v){
             $selected = ($k == $params['name']) ? 'selected="selected"':'';
             $searchSelect .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
         }
         $searchSelect .= '</select>';
         return $searchSelect;
     }

    /**
     * Get tool bar
     * @param $operations
     * @return string
     *
     * @author liupf 2017/9/21
     */
    public static function getToolBar($operations){
        $toolBar = '';
        foreach($operations as $k=>$v){
            switch( $k){
                case   'edit'  : $temp = static::getToolEdit($v);break;
                case   'add'   : $temp = static::getToolAdd($v);break;
                case   'delete': $temp = static::getToolDelete($v['url']);break;
                default        : $temp = '';break;
            }
            $toolBar .= $temp;
        }
        return $toolBar;
    }

    /**
     * Get tool bar edit
     *
     * @param $operation
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getToolEdit($operation){
        return '<li><a class="edit" href="'.$operation['url'].'?id={id}" target="dialog" height="'.$operation['height'].'" width="'.$operation['width'].'" drawable="true" mask="true"><span>修改</span></a></li>';
    }

    /**
     * Get tool bar add
     *
     * @param $operation
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getToolAdd($operation){
        return '<li><a class="add" href="'.$operation['url'].'"  target="dialog" height="'.$operation['height'].'" width="'.$operation['width'].'" drawable="true" mask="true"><span>添加</span></a></li>';
     }

    /**
     * Get tool bar delete
     *
     * @param $url
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getToolDelete($url){
        return '<li><a class="delete" href="'.$url.'" target="selectedTodo" title="确实要删除这些记录吗?"  rel="ids" postType="string"><span>批量删除</span></a></li>';
    }

    /**
     * @param $tableFields
     * @param $operations
     * @param $orderFiled
     * @param $orderDirection
     * @return string
     */
    public static function getTableHead($tableFields,$operations,$orderFiled,$orderDirection){
        $tableHead = '<tr>';
        if($operations['edit'] || $operations['delete'] ){
            $tableHead .= '<th width="22"><input type="checkbox" group="ids" class="checkboxCtrl"></th>';
        }
        foreach($tableFields as $taleFiled){
            $width = $taleFiled['width'] ? 'width="'.$taleFiled['width'].'"' : '';
            $order = $taleFiled['orderField'] ? 'orderField="'.$taleFiled['name'].'"':'';
            $class = $taleFiled['name'] == $orderFiled ? 'class="'.$orderDirection.'"':'';
            $tableHead .= '<th '.$width.' '.$order.' '.$class.'>'.$taleFiled['label'].'</th>';
        }
        if($operations['edit'] || $operations['delete'] ){
            $tableHead .= '<th width="80" >编辑</th>';
        }
        $tableHead .= '</tr>';
        return $tableHead;
    }

    /**
     * Get table body
     *
     * @param $data
     * @param $tableFields
     * @param $operations
     * @return string
     */
    public static function getTableBody($data,$tableFields,$operations){
        $tableBody = '';
        foreach($data as $t){
            $tableBody .= '<tr target="id" rel="'.$t['id'].'">';
            if($operations['edit'] || $operations['delete'] ){
                $tableBody .= '<td><input name="ids" value="'.$t['id'].'" type="checkbox"></td>';
            }
            foreach($tableFields as $tableField){
                if(isset($tableField['values'])){
                    $tableBody .= '<td>'.$tableField['values'][$t[$tableField['name']]].'</td>';
                }else{
                    $tableBody .= '<td>'.$t[$tableField['name']].'</td>';
                }
            }
            if($operations['edit'] || $operations['delete'] ){
                $tableBody .= static::getOperationBar($operations,$t['id']);
            }
            $tableBody .= '</tr>';
        }
        return $tableBody;
    }

    /**
     * Get operation bar
     *
     * @param $operations
     * @param $id
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getOperationBar($operations,$id){
        $operationBar = '<td>';
        foreach($operations as $k=>$v){
            switch($k){
                case   'edit'  : $temp = static::getOperationEdit($v,$id);break;
                case   'delete': $temp = static::getOperationDelete($v,$id);break;
                default        : $temp = '';break;
            }
            $operationBar .= $temp;
        }
        $operationBar .= '</td>';
        return $operationBar;
    }

    /**
     * Get operation bar edit
     *
     * @param $operation
     * @param $id
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getOperationEdit($operation,$id){
        return '<a class="btnEdit" href="'.$operation['url'].'?id='.$id.'" title="编辑" target="dialog" mask="true" drawable="true" width="'.$operation['width'].'" height="'.$operation['height'].'">编辑</a>';
    }

    /**
     * Get operation bar delete
     *
     * @param $url
     * @param $id
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getOperationDelete($url,$id){
        return '<a  class="btnDel" href="'.$url.'?ids='.$id.'" title="删除" target="ajaxTodo">删除</a>';
    }

    /**
     * Get pager bar
     * @param $numPerPage
     * @param $pageNum
     * @param $numCount
     * @return string
     * @author liupf  2017/9/21
     */
    public static function getPagerBar($numPerPage,$pageNum,$numCount){
        return 	'<div class="pages">
					<span>显示</span>
					<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
						<option '.($numPerPage == 2 ? 'selected': '' ).' value="2">2</option>
						<option '.($numPerPage == 6 ? 'selected': '' ).' value="6">6</option>
						<option '.($numPerPage == 20 ? 'selected': '' ).' value="20">20</option>
						<option '.($numPerPage == 50 ? 'selected': '' ).'  value="50">50</option>
						<option '.($numPerPage == 100 ? 'selected': '' ).'  value="100">100</option>
						<option '.($numPerPage == 200 ? 'selected': '' ).'  value="200">200</option>
					</select>
					<span>条，共'.$numCount.'条</span>
				</div>
				<div class="pagination" targetType="navTab" totalCount="'.$numCount.'" numPerPage="'.$numPerPage.'" pageNumShown="10" currentPage="'.$pageNum.'"></div>';
    }

    /**
     * Get csrf
     *
     * @param $name
     * @param $value
     * @return string
     * @author liupf  2017/9/22
     */
    public static function getCsrf($name,$value){
        return '<input name="'.$name.'" type="hidden" id="'.$name.'" value="'.$value.'">';
    }

    /**
     * Get Edit field  set
     *
     * @param $editFields
     * @param $model
     * @return string
     * @author liupf  2017/9/25
     */
    public static function getEditFieldSet($editFields,$model){
        $editFieldSet = '';
        foreach($editFields as $editField){
            $value = $model->$editField['name'] ?:'';
            switch( $editField['type']){
                case   'text'  : $temp = static::getEditFieldText($editField,$value);break;
                case   'date'  : $temp = static::getEditFieldDate($editField,$value);break;
                case   'select': $temp = static::getEditFieldSelect($editField,$value);break;
                default        : $temp = '';break;
            }
            $editFieldSet .= $temp;
        }
        return $editFieldSet;
    }

    /**
     * Get edit field text
     *
     * @param $editField
     * @param $value
     * @return string
     * @author liupf  2017/9/22
     */
    public static function getEditFieldText($editField,$value){
        $str = '<dl>';
        $str .= '<dt>'.$editField['label'].'：</dt>';
        $str .= '<dd><input class="'.($editField['required']?'required':'').'" '.($editField['readonly']? 'readonly':'').' name="editForm['.$editField['name'].']" value="'.$value.'" type="text" size="30" /></dd>';
        $str .=' </dl>';
        return $str;
    }

    /**
     * Get edit field date
     *
     * @param $editField
     * @param $value
     * @return string
     * @author liupf  2017/9/22
     */
    public static function getEditFieldDate($editField,$value){
        $str = '<dl>';
        $str .= '<dt>'.$editField['label'].'：</dt>';
        $str .= '<dd><input class="date" readonly name="editForm['.$editField['name'].']" value="'.$value.'" type="text" size="30" /></dd>';
        $str .= '<a class="inputDateButton" href="javascript:;">选择</a>';
        $str .=' </dl>';
        return $str;
    }

    /**
     * Get edit field select
     *
     * @param $editField
     * @param $value
     * @return string
     * @author liupf  2017/9/22
     */
    public static function getEditFieldSelect($editField,$value){
        $str = '<dl>';
        $str .= '<dt>'.$editField['label'].'：</dt>';
        $str .= '<dd><select class="combox" name="editForm['.$editField['name'].']">';
        foreach($editField['values'] as $k=>$v){
            $selected = ($k == $value) ? 'selected="selected"':'';
            $str .= '<option value="'.$k.'" '.$selected.'>'.$v.'</option>';
        }
        $str .= '</select></dd></dl>';
        return $str;
    }

}