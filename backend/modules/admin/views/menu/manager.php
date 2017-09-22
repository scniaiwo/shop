<form id="pagerForm" method="post" action="<?= \helpers\CUrl::getCurrentUrl();  ?>">
    <?=  \helpers\CRequest::getCsrfHtml(); ?>
</form>
<div class="pageContent" style="padding:5px">
    <div class="panel" defH="40">
        <h1>菜单基本信息</h1>
        <div>
            <ul class="leftTools">
                <li>
                    <a class="button" target="dialog" href="<?= \helpers\CUrl::create('/admin/menu/create',true)?>"mask="true">
                        <span>创建菜单</span>
                    </a>
                </li>
                <li>
                    <a class="button deleteMenu" href="javascript:" rel="<?= \helpers\CUrl::create('/admin/menu/delete',true)?>" mask="true">
                        <span>删除菜单</span>
                    </a>
                    <a class="btnDel btnDelMenu" style="display:none;" target="ajaxTodo" rel="pagerForm" title="删除后，菜单对应的所有子菜单都会被删除，确定操作吗？">删除</a>
                </li>
            </ul>
        </div>
    </div>
    <script>
        $(".deleteMenu").click(function(){
            menuID = $("#current_parent_id").val();
            if(menuID){
                href = $(this).attr("rel");
                $(".btnDelMenu").attr("href",href+"?id="+menuID).click();
            }else{
                alertMsg.error('you must chose a category to delete!')
            }

        });
    </script>

    <div class="divider"></div>
    <div class="tabs">
        <div>
            <div layoutH="146" style="float:left; display:block; overflow:auto; width:240px; border:solid 1px #CCC; line-height:21px; background:#fff">
                <ul class="tree treeFolder">
                    <?= $this->render('_tree');?>
                </ul>
            </div>

            <div layoutH="146"  id="jbsxBox" class="unitBox pageFormContent" style="margin-left:241px;display:block; overflow:auto; width:auto; border:solid 1px #CCC; line-height:21px; background:#fff">

            </div>
        </div>

    </div>

</div>






