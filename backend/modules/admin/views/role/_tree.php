<?php
/**
 * Created by PhpStorm.
 * User: liupf
 * Date: 17-9-13
 * Time: 下午1:52
 */
$tree = \services\MenuService::factory()->tree(0);
?>
<?php foreach($tree as $node):?>
        <li><a tname="menuIDs" tvalue="<?= $node['id'];?>"><?= $node['name'];?></a>
            <?php if($node['child']):?>
            <ul>
                <?php foreach($node['child'] as $childNode):?>
                    <?php  if($childNode['child']):?>
                        <li><a tname="menuIDs" tvalue="<?= $childNode['id'];?>"><?= $childNode['name'];?></a>
                            <ul>
                                <?php foreach($childNode['child'] as $subNode):?>
                                <li><a tname="menuIDs" tvalue="<?= $subNode['id'];?>"><?= $subNode['name'];?></a></li>
                                <?php endforeach ?>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li><a tname="menuIDs" tvalue="<?= $childNode['id'];?>"><?= $childNode['name'];?></a></li>
                    <?php endif?>
                <?php endforeach ?>
            </ul>
            <?php endif?>
        </li>
<?php endforeach ?>
