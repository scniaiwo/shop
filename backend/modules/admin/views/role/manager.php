<form id="pagerForm" method="post" action="<?= \helpers\CUrl::getCurrentUrl();?>">
    <?= \helpers\CRequest::getCsrfHtml();?>
    <?= $pagerForm; ?>
</form>
<div class="pageHeader">
    <form rel="pagerForm" onsubmit="return navTabSearch(this);" action="<?= \helpers\CUrl::getCurrentUrl();?>" method="post">
        <?= \helpers\CRequest::getCsrfHtml(); ?>
        <div class="searchBar">
            <?= $searchBar;?>
        </div>
    </form>
</div>

<div class="pageContent">
    <div class="panelBar">
        <ul class="toolBar">
            <?= $toolBar;?>
        </ul>
    </div>
    <div class="panelBar" >
        <?= $pagerBar;?>
    </div>
    <div id="w_list_print">
        <table class="list" width="98%" targetType="navTab" asc="asc" desc="desc" layoutH="116">
            <thead>
                <?= $tableHead;?>
            </thead>
            <tbody>
                <?= $tableBody;?>
            </tbody>
        </table>
    </div>

</div>
