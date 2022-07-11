<?php

use app\models\Recipe;
use yii\helpers\Url;

/**
 * @var Recipe $recipe
 */

?>

<div class="recipe">
    <div class="recipe__name"><?= $recipe->name ?></div>
    <ul class="recipe__ingredients">
        <?php foreach ($recipe->recipeIngredients as $recipeIngredient): ?>
            <li class="recipe__ingredient">
                <a href="<?= Url::to([]) ?>" class="recipe__ingredientName"><?= $recipeIngredient->ingredient->name ?></a>
                <?php if ($recipeIngredient->ingredient->link): ?>
                    <a href="<?= $recipeIngredient->ingredient->link ?>" class="recipe__ingredientLink" title="<?= Yii::t('app', 'Как приготовить') ?>">
                        &#128279;
                    </a>
                <?php endif; ?>
                <?php if ($recipeIngredient->value): ?>
                    <span class="recipe__ingredientQuantity"><?= $recipeIngredient->value ?></span>
                    <span class="recipe__ingredientValue"><?= $recipeIngredient->measure_unit ?></span>
                <?php else: ?>
                    <span class="recipe__ingredientQuantity"><?= Yii::t('app', 'по вкусу') ?></span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <div class="recipe__description">
        <?= $recipe->description ?>
    </div>
    <div class="recipe__timelines">
        <?php foreach ($recipe->timelines as $timeline): ?>
            <div class="timeline" data-type="visual" data-start="0" data-end="<?= $recipe->length ?>">
                <div class="timeline__typeToggles">
                    <span class="timeline__typeToggle" data-type="visual"><?= Yii::t('app', 'шкала') ?></span>
                    <span class="timeline__typeToggle" data-type="text"><?= Yii::t('app', 'текст') ?></span>
                </div>
                <?php if ($timeline->name): ?>
                    <div class="timeline__name"><?= $timeline->name ?></div>
                <?php endif; ?>
                <div class="timeline__events">
                    <?php foreach ($timeline->timelineEvents as $i => $timelineEvent): ?>
                        <div class="timeline__event" style="z-index:<?= $timelineEvent->id ?>;top: <?= round(100 * ($timelineEvent->time / $recipe->length), 2) ?>%">
                            <div class="timeline__eventTime"><?= $timelineEvent->time ?>&nbsp;<?= Yii::t('app', 'мин') ?></div>
                            <div class="timeline__eventName"><?= $timelineEvent->name ?></div>
                            <div class="timeline__eventDescription"><?= $timelineEvent->description ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>