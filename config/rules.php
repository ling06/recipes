<?php
return [
    'recipes/index' => 'recipe/list',
    'recipe/<id:\d+>_<slug:\w+>' => 'recipe/view',

    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
];
