<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-13
 * Time: 下午1:52
 */
use  helpers\CUrl;
$tree = \services\MenuService::factory()->tree(0);
?>
<?php foreach($tree as $node):?>
        <li><a href="<?= CUrl::create(['/admin/menu/edit','id'=>$node['id']],true); ?>" target="ajax" rel="jbsxBox"><?= $node['name'];?></a>
            <?php if($node['child']):?>
            <ul>
                <?php foreach($node['child'] as $childNode):?>
                    <?php  if($childNode['child']):?>
                        <li><a href="<?= CUrl::create(['/admin/menu/edit','id'=>$childNode['id']],true); ?>" target="ajax" rel="jbsxBox"><?= $childNode['name'];?></a>
                            <ul>
                                <?php foreach($childNode['child'] as $subNode):?>
                                <li><a href="<?= CUrl::create(['/admin/menu/edit','id'=>$subNode['id']],true); ?>" target="ajax" rel="jbsxBox"><?= $subNode['name'];?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= CUrl::create(['/admin/menu/edit','id'=>$childNode['id']],true); ?>" target="ajax" rel="jbsxBox"><?= $childNode['name'];?></a></li>
                    <?php endif?>
                <?php endforeach ?>
            </ul>
            <?php endif?>
        </li>
<?php endforeach ?>
