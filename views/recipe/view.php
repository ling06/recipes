<?php

use app\models\Recipe;
use yii\helpers\Url;

/**
 * @var Recipe $recipe
 */

$searchModel = new \app\models\searchers\RecipeSearcher();
?>

<div class="recipe">
    <div class="recipe__name">
        <?= $recipe->name ?>
        <?php if ($recipe->canBeUpdated()): ?>
            <a class="fa fa-edit recipe__editLink" href="<?= Url::to(['recipe/update', 'id' => $recipe->id]) ?>" title="<?= Yii::t('app', 'Редактировать') ?>"></a>
        <?php endif; ?>
    </div>
    <ul class="recipe__ingredients">
        <?php foreach ($recipe->recipeIngredients as $recipeIngredient): ?>
            <li class="recipe__ingredient">
                <a href="<?= Url::to(['recipes/index', $searchModel->formName() => ['ingredient_id' => $recipeIngredient->ingredient_id]]) ?>" class="recipe__ingredientName"><?= $recipeIngredient->ingredient->name ?></a>
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
                    <span class="timeline__typeToggle stateToggle" data-parent=".timeline" data-type="type" data-state="visual"><?= Yii::t('app', 'шкала') ?></span>
                    <span class="timeline__typeToggle stateToggle" data-parent=".timeline" data-type="type" data-state="text"><?= Yii::t('app', 'текст') ?></span>
                </div>
                <?php if ($timeline->name): ?>
                    <div class="timeline__name"><?= $timeline->name ?></div>
                <?php endif; ?>
                <div class="timeline__events">
                    <?php foreach ($timeline->timelineEvents as $i => $timelineEvent): ?>
                        <div class="timeline__event classToggle"
                             data-class="timeline__event_expanded"
                             data-parent=".timeline__event"
                             style="z-index:<?= $timelineEvent->id ?>;top: <?= round(100 * ($timelineEvent->time / $recipe->length), 2) ?>%"
                        >
                            <div class="timeline__eventTime"><?= $timelineEvent->time ?>&nbsp;<?= Yii::t('app', 'мин') ?></div>
                            <div class="timeline__eventName"><?= $timelineEvent->name ?></div>
                            <div class="timeline__eventDescription"><?= $timelineEvent->description ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="recipe__actions">
        <?php if ($recipe->canBeUpdated()): ?>
        <a href="<?= Url::to(['recipe/update', 'id' => $recipe->id]) ?>" class="btn btn_type_success" title="<?= Yii::t('app', 'Редактировать') ?>">
            <i class="fa fa-edit"></i>
        </a>
        <?php endif; ?>
        <?php if ($recipe->canBeDeleted()): ?>
        <form
            action="<?= Url::to(['recipe/delete', 'id' => $recipe->id]) ?>"
            method="post"
            class="recipe__deleteForm confirmDelete"
            data-message="<?= Yii::t('app', 'Точно удалить рецепт?') ?>"
        >
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            <button class="btn btn_type_error recipe__deleteFormButton" title="<?= Yii::t('app', 'Удалить') ?>">
                <i class="fa fa-trash-can"></i>
            </button>
        </form>
        <?php endif; ?>
    </div>
</div>