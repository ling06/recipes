<?php
return [
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',

    'recipes/index' => 'recipe/list',
    'recipe/<id:\d+>_<slug:\w+>' => 'recipe/view',
];
