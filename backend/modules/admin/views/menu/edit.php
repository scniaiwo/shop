<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/menu/modify',true);?>" class="pageForm required-validate" onsubmit="return validateCallback(this, navTabAjaxDone);">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <div class="pageFormContent"  style="height:265px;">
                    <p>
                        <label>id：</label>
                        <input type="text"  id="current_parent_id"  value="<?=$menu->id; ?>" size="30" name="editForm[id]" readonly="readonly" class="readonly">
                    </p>
                    <p>
                        <label>ParentId</label>
                        <input type="text"  value="<?=$menu->parent_id; ?>" size="30" name="editForm[parent_id]" readonly="readonly" class="readonly">
                    </p>
                    <p>
                        <label>Name:</label>
                        <input type="text" id="current_parent_menu"  value="<?=$menu->name; ?>" size="30" name="editForm[name]" class="required" maxlength="150">
                    </p>
                    <p>
                        <label>Url Key</label>
                        <input type="text"  value="<?=$menu->url_key; ?>" size="30" name="editForm[url_key]" class="required" maxlength="255">
                    </p>
                    <p>
                        <label>SortOrder</label>
                        <input type="text"  value="<?=$menu->sort_order; ?>" size="30" name="editForm[sort_order]" class="required">
                    </p>

                    <div style="clear:both;"></div>
                    <br/>
                    <div>
                        <span style="line-height:18px;">
                            Role Key说明:在Url Key的基础上去掉action部分,如果不填写，系统自动去掉Url Key的最后部分
            				,譬如 url_key = /fecadmin/menu/manager   ，系统自动生成/fecadmin/menu。
            				如果url_key = /fecadmin/menu/index，但是您填写的url_key = /fecadmin/menu，系统自动生成/fecadmin，就会报错！
            				所以，请填写完整的url key, 不要省略掉index部分。如果省略掉，则需要手动填写Role Key的值
            			</span>
                    </div>
        </div>
        <div class="formBar">
            <ul>
                <!--<li><a class="buttonActive" href="javascript:;"><span>保存</span></a></li>-->
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit">保存</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>