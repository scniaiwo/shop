<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/role/add')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <input id="selectIDs" type="text" name="editForm[selectIDs]" size="30" hidden="hidden" class="required"/>
        <div class="pageFormContent" layoutH="58">
            <fieldset>
                <legend>基本信息</legend>
                <?= $editFieldsHtml; ?>
            </fieldset>
            <fieldset>
                <legend>权限选择</legend>
                <div class="select_tree" style="display:block; overflow:auto; width:auto; border:solid 1px #CCC; line-height:21px; background:#fff">
                    <ul class="tree treeFolder treeCheck expand">
                        <?= $this->render('_tree');?>
                    </ul>
                </div>
            </fieldset>
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