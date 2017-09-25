<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/role/modify')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <input id="selectIDs" type="text" name="editForm[selectIDs]" size="30" hidden="hidden" class="required"/>
        <input type="text" name="editForm[id]" size="30" value="<?= $role->id;?>" hidden="hidden" class="required"/>
        <div class="pageContent sortDrag" selector="h1" layoutH="42">
            <div class="panel" defH="55">
                <h1>基本信息</h1>
                <div>
                    <div class="pageFormContent">
                        <p>
                            <label>角色名：</label>
                            <input type="text" name="editForm[name]" size="30" value="<?= $role->name;?>" class="required"/>
                        </p>
                        <p>
                            <label>角色描述：</label>
                            <input type="text" name="editForm[description]" value="<?= $role->description;?>" size="30" class="required"/>
                        </p>
                    </div>
                </div>
            </div>

            <div class="panel" defH="330">
                <h1>权限选择</h1>
                <div class="select_tree" style="display:block; overflow:auto; width:auto; border:solid 1px #CCC; line-height:21px; background:#fff">
                    <ul class="tree treeFolder treeCheck expand">
                        <?= $this->render('_editTree',['menuIDs'=>$menuIDs]);?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit" onclick="setSelectIDs()">提交</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>