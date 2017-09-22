<?php

// 本文件在web/index.php 处引入。
$modules = [];
foreach (glob(__DIR__.'/modules/*.php') as $filename) {
    $modules = array_merge($modules, require($filename));
}
return [
    'modules'  => $modules,
];
