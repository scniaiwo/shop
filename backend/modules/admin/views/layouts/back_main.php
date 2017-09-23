<?php
/* @var $this \yii\web\View */
/* @var $content string */

use  backend\assets\AppAsset;
AppAsset::register($this);
?>

<?php $this->beginPage();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=7" />
    <title>MyShop</title>
    <?php $this->head(); ?>
    <style type="text/css">
        #header{height:85px}
        #leftside, #container, #splitBar, #splitBarProxy{top:90px}
    </style>
    <script>
        <?php
        $publishedPath = $this->assetManager->publish('@backend/assets/dwz_jui/dwz.frag.xml');
        $loginDialogUrl= \helpers\CUrl::create('/login/dialog')
         ?>
        $(function(){
            DWZ.init("<?= $publishedPath[1]; ?>", {
                loginUrl:"<?= $loginDialogUrl;?>", loginTitle:"登录",	// 弹出登录对话框
                //		loginUrl:"login.html",	// 跳到登录页面
                statusCode:{ok:200, error:300, timeout:301}, //【可选】
                keys: {statusCode:"statusCode", message:"message"}, //【可选】
                pageInfo:{pageNum:"pageNum", numPerPage:"numPerPage", orderField:"orderField", orderDirection:"orderDirection"}, //【可选】
                debug:false,	// 调试模式 【true|false】
                callback:function(){
                    initEnv();
//                    $("#themeList").theme({themeBase:"themes"});
                    setTimeout(function() {$("#sidebar .toggleCollapse div").trigger("click");}, 10);
                }
            });
        });
    </script>
</head>

<body scroll="no">
<?php $this->beginBody(); ?>
<div id="layout">
    <div id="header">
        <div class="headerNav">
            <a class="logo" href="http://j-ui.com">标志</a>
            <ul class="nav">
                <li><a href="<?= \yii\helpers\Url::to('/logout/index')?>">退出</a></li>
            </ul>
        </div>
    </div>
    <div id="leftside">
        <div id="sidebar_s">
            <div class="collapse">
                <div class="toggleCollapse"><div></div></div>
            </div>
        </div>
        <div id="sidebar">
            <div class="toggleCollapse"><h2>主菜单</h2><div>收缩</div></div>
            <div class="accordion" fillSpace="sidebar">
                <?= $this->render('_menu') ?>
            </div>
        </div>
    </div>
    <div id="container">
        <div id="navTab" class="tabsPage">
            <div class="tabsPageHeader">
                <div class="tabsPageHeaderContent"><!-- 显示左右控制时添加 class="tabsPageHeaderMargin" -->
                    <ul class="navTab-tab">
                        <li tabid="main" class="main"><a href="javascript:;"><span><span class="home_icon">我的主页</span></span></a></li>
                    </ul>
                </div>
                <div class="tabsLeft">left</div><!-- 禁用只需要添加一个样式 class="tabsLeft tabsLeftDisabled" -->
                <div class="tabsRight">right</div><!-- 禁用只需要添加一个样式 class="tabsRight tabsRightDisabled" -->
                <div class="tabsMore">more</div>
            </div>
            <ul class="tabsMoreList">
                <li><a href="javascript:;">我的主页</a></li>
            </ul>
            <div class="navTab-panel tabsPageContent layoutBox">
                <div class="page unitBox">
                    <div class="accountInfo">
                        <p><span>您好：超级管理员</span></p>
                    </div>
                    <div class="pageFormContent" layoutH="80" style="margin-right:230px">
                        <ul style="line-height:30px;text-align:center;margin-top:30px;">
                            <li>
                                <h1 style="font-size:36px;"> Myshop后台管理系统</h1>
                            </li>
                            <li>
                                <div style="padding-top:150px;">
                                    注：如果权限不够，请联系管理员开通权限。
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--<div id="footer">Copyright &copy; 2010 <a href="demo_page2.html" target="dialog">DWZ团队</a></div>-->
<?php $this->endBody(); ?>
</body>
</html>
<?php $this->endPage();?>