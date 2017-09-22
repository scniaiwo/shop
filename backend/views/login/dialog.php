
<div class="pageContent">

    <form method="post" action="<?= \helpers\CUrl::create('login/dialog',true);?>" class="pageForm" onsubmit="return validateCallback(this, dialogAjaxDone)">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <div class="pageFormContent" layoutH="58">
            <div class="unit">
                <label>用户名：</label>
                <input type="text" name="login[username]" size="30" class="required"/>
            </div>
            <div class="unit">
                <label>密码：</label>
                <input type="password" name="login[password]" size="30" class="required"/>
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

