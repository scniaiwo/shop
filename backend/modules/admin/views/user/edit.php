<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/user/modify')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <div class="pageFormContent" layoutH="58">
            <fieldset>
                <legend>基本信息</legend>
                <?= $editFieldsHtml; ?>
            </fieldset>
            <fieldset>
                <legend>角色信息</legend>
                <?php foreach($roles as $role):?>
                    <?php
                        $checked = in_array($role['id'],$cRoleIDs)?'checked':'';
                    ?>
                    <label><input type="checkbox" <?= $checked;?> name="roleIDs[<?= $role['id'];?>]" value="<?= $role['id'];?>" /><?= $role['name'];?></label>
                <?php endforeach ?>
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
