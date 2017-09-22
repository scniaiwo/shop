<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-13
 * Time: 下午1:52
 */
use helpers\CUrl;
$tree = \services\MenuService::factory()->getUserMenu();
//\helpers\CResponse::cjson($tree);exit;
?>
<?php foreach($tree as $node):?>
    <?php if($node['child']):?>
        <div class="accordionHeader">
            <h2><span>Folder</span><?= $node['name'];?></h2>
        </div>
        <div class="accordionContent">
            <ul class="tree treeFolder">
            <?php foreach($node['child'] as $childNode):?>
                <?php if($childNode['child']):?>
                <li><a href="javascript:void(0)"><?= $childNode['name'];?></a>
                    <ul>
                        <?php foreach($childNode['child'] as $subNode) :?>
                        <li><a href="<?= CUrl::create($subNode['url_key'],true);?>" target="navTab" rel="<?= 'navTab_'.$subNode['id'];?>"><?= $subNode['name'];?></a></li>
                        <?php endforeach ?>
                    </ul>
                </li>
                 <?php else : ?>
                <li><a href="<?= CUrl::create($childNode['url_key'],true);?>" target="navTab" rel="<?= 'navTab_'.$childNode['id'];?>"><?= $childNode['name'];?></a></li>
                <?php endif ?>
            <?php endforeach ?>
            </ul>
        </div>
        <?php endif ?>
<?php endforeach ?>
