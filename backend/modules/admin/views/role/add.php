<div class="pageContent">
    <form method="post" action="<?= \helpers\CUrl::create('/admin/role/save')?>" class="pageForm required-validate" onsubmit="return validateCallback(this,dialogAjaxDone)" ref="pagerForm">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <input id="menu" type="text" name="createForm[menuIDs]" size="30" hidden="hidden" class="required"/>
        <div class="pageContent sortDrag" selector="h1" layoutH="42">
            <div class="panel" defH="55">
                <h1>基本信息</h1>
                <div>
                        <div class="pageFormContent">
                            <p>
                                <label>角色名：</label>
                                <input type="text" name="createForm[name]" size="30" class="required"/>
                            </p>
                            <p>
                                <label>角色描述：</label>
                                <input type="text" name="createForm[description]" size="30" class="required"/>
                            </p>
                        </div>
                </div>
            </div>

            <div class="panel" defH="330">
                <h1>权限选择</h1>
                <div class="menu_tree" style="display:block; overflow:auto; width:auto; border:solid 1px #CCC; line-height:21px; background:#fff">
                    <ul class="tree treeFolder treeCheck expand">
                        <?= $this->render('_tree');?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="formBar">
            <ul>
                <li><div class="buttonActive"><div class="buttonContent"><button type="submit" onclick="setMenuIds()">提交</button></div></div></li>
                <li>
                    <div class="button"><div class="buttonContent"><button type="button" class="close">取消</button></div></div>
                </li>
            </ul>
        </div>
    </form>
</div>
<script type="text/javascript">
//    function kkk(){
//        var json = arguments[0], result="";
//        $(json.items).each(function(i){
//            result += "<p>name:"+this.name + " value:"+this.value+" text: "+this.text+"</p>";
//        });
//        $("#resultBox").html(result);
//    }
    function setMenuIds(){
        var menuIds = "";
        $(".menu_tree div.ckbox.checked").each(function(){
            var menuID = $(this).find("input").val();
            menuIds += menuID+",";
        });
        $(".menu_tree div.ckbox.indeterminate").each(function(){
            var menuID = $(this).find("input").val();
            menuIds += menuID+",";
        });
        $("#menu").val(menuIds);

    }
</script>