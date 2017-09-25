
<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/user/change-password') ?>" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml();?>
        <div class="pageFormContent" layoutH="56" style="width:450px;">
            <p>
                <label>账号：</label>
                <input    value="<?php echo $name; ?>" name="" id="username"  type="text" size="30" readonly="readonly"/>
            </p>
            <p>
                <label>旧密码：</label>
                <input class=" "  title="old Password" value="" name="passwordForm[password]" id="old_password" type="password" size="30" />
            </p>
            <p>

                <label>新密码：</label>
                <input    class=" "   title="New Password" value="" name="passwordForm[newPassword]" id="newPassword" type="password" size="30" />
            </p>
            <p>
                <label>密码确认：</label>

                <input class="" equalto="#newPassword" value="" name="passwordForm[rePassword]" id="rePassword" type="password"  size="30"  >
            </p>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
