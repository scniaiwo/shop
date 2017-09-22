<?php
return [
    'AdminUser' => [
        'class' => 'services\AdminUser',
        'childService' => [
            'Role' => [
                'class' => 'services\AdminUser\Role',
            ],
            'Menu' => [
                'class' => 'services\AdminUser\Menu',
            ],
        ]
    ],
];
