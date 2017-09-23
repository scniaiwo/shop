<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/menu/save',true);?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <div class="pageFormContent" layoutH="58">
            <div class="unit">
                <label>ParentId：</label>
                <input id="create_parent_id" type="text" name="createForm[parent_id]" size="30" readonly="readonly" class="required" />
            </div>
            <div class="unit">
                <label>上级菜单：</label>
                <input id="create_parent_menu" type="text" name="patientName" size="30"/>
            </div>
            <div class="unit">
                <label>Name：</label>
                <input type="text" name="createForm[name]" size="30" class="required" maxlength="150"/>
            </div>
            <div class="unit">
                <label>Url Key：</label>
                <input type="text" name="createForm[url_key]" size="30" class="required" maxlength="255"/>
            </div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">提交</button></div></div></li>
                <li><div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div></li>
            </ul>
        </div>
    </form>
</div>
<script>
    parent_menu_id = $("#current_parent_id").val();
    if(!parent_menu_id){
        parent_menu_id= 0;
    }
    $("#create_parent_id").val(parent_menu_id);
    parent_menu_name = $("#current_parent_menu").val();
    if(!parent_menu_name){
        parent_menu_name = 'Root';
    }
    $("#create_parent_menu").val(parent_menu_name);
</script>
