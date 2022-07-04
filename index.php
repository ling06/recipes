<?php
$values = [
    1 => ['name' => 'мм'],
    2 => ['name' => 'см'],
    3 => ['name' => 'м'],
    4 => ['name' => 'мг'],
    5 => ['name' => 'г'],
    6 => ['name' => 'кг'],
    7 => ['name' => 'мл'],
    8 => ['name' => 'л'],
    9 => ['name' => 'шт'],
    10 => ['name' => 'ст. ложка'],
    11 => ['name' => 'ч. ложка'],
];

$recipe = [
	'name' => 'Бефстроганов из говядины',
	'length' => 45,
    'portions' => 4,
];

$ingredients = [
    [
        'name' => 'Говядина',
        'quantity' => 500,
        'value_id' => 5,
    ],
    [
        'name' => 'Лук',
        'quantity' => 1,
        'value_id' => 9,
    ],
    [
        'name' => 'Сметана',
        'quantity' => 150,
        'value_id' => 5,
    ],
    [
        'name' => 'Мука',
        'quantity' => 1,
        'value_id' => 10,
    ],
    [
        'name' => 'Томатная паста',
        'quantity' => 1,
        'value_id' => 10,
    ],
    [
        'name' => 'Вода',
        'quantity' => 150,
        'value_id' => 7,
    ],
    [
        'name' => 'Соль',
        'quantity' => 0,
        'value_id' => 1,
    ],
    [
        'name' => 'Перец черный',
        'quantity' => 0,
        'value_id' => 1,
    ],
];

$timelines = [
    [
        'name' => '',
        'events' => [
            [
                'time' => 0,
                'event_id' => 1,
            ],
            [
                'time' => 15,
                'event_id' => 2,
            ],
            [
                'time' => 25,
                'event_id' => 3,
            ],
            [
                'time' => 30,
                'event_id' => 4,
            ],
            [
                'time' => 35,
                'event_id' => 5,
            ],
        ],
    ],
];

$events = [
	1 => [
	    'name' => 'Подготовка',
        'description' => 'Мясо режем поперек волокон на соломку толщиной примерно 5 мм. Лук режем четвертькольцами.',
	],
	2 => [
	    'name' => 'Жарим мясо',
        'description' => 'На раскаленной сковороде в масле обжариваем мясо. За раз кидаем немного мяса чтобы не слипалось и обжариваем до корочки с каждой стороны. Убираем мясо в сторонку.',
	],
	3 => [
	    'name' => 'Жарим лук',
        'description' => 'На той же сковороде в масле обжариваем лук до золотистого цвета. Посыпаем мукой и жарим еще 1 минуту.',
	],
	4 => [
	    'name' => 'Смешиваем, готовим',
        'description' => 'Добавляем сметану, томатную пасту и воду. Все хорошо перемешиваем. Добавляем мясо, солим, перчим по вкусу и тушим 5 минут.',
	],
	5 => [
	    'name' => 'Тушим до готовности',
        'description' => 'Проверяем мясо. Если мягкое, то все отлично. Если жесткое, закрываем крышкой и тушим до готовности.',
	],
];

?>
<!doctype html>
<html lang="ru">
<head>
    <title><?= $recipe['name'] ?></title>
    <link rel="stylesheet" href="web/css/styles.css">
</head>
<body>

<div class="wrapper">

    <div class="recipe">
        <div class="recipe__name"><?= $recipe['name'] ?></div>
        <div class="recipe__ingredients">
            <?php foreach ($ingredients as $ingredient): ?>
                <div class="recipe__ingredient">
                    <span class="recipe__ingredientName"><?= $ingredient['name'] ?></span>
                    <?php if ($ingredient['quantity']): ?>
                    <span class="recipe__ingredientQuantity"><?= $ingredient['quantity'] ?></span>
                    <span class="recipe__ingredientValue"><?= $values[$ingredient['value_id']]['name'] ?></span>
                    <?php else: ?>
                        <span class="recipe__ingredientQuantity">по вкусу</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="recipe__timelines">
            <?php foreach ($timelines as $timeline): ?>
            <div class="timeline" data-type="visual" data-start="0" data-end="<?= $recipe['length'] ?>">
                <div class="timeline__typeToggles">
                    <span class="timeline__typeToggle" data-type="visual">шкала</span>
                    <span class="timeline__typeToggle" data-type="text">текст</span>
                </div>
                <?php if ($timeline['name']): ?>
                    <div class="timeline__name"></div>
                <?php endif; ?>
                <div class="timeline__events">
                    <?php foreach ($timeline['events'] as $i => $event): ?>
                        <div class="timeline__event" style="z-index:<?= $i ?>;top: <?= round(100 * ($event['time'] / $recipe['length']), 2) ?>%">
                            <div class="timeline__eventTime"><?= $event['time'] ?> мин</div>
                            <div class="timeline__eventName"><?= $events[$event['event_id']]['name'] ?></div>
                            <div class="timeline__eventDescription"><?= $events[$event['event_id']]['description'] ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

</div>

<script src="web/scripts/script.js"></script>
</body>
</html>
