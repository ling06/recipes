<?php

use app\models\Ingredient;
use app\models\MeasureUnit;
use app\models\RecipeIngredient;
use app\models\RecipeTypes;
use app\models\Timeline;
use app\models\TimelineEvent;
use app\models\forms\RecipeCreateForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm;

/**
 * @var View $this
 * @var RecipeCreateForm|null $model
 * @var string $action
 */
$this->registerJsFile('@web/js/recipe/create.js', ['position' => View::POS_END]);

$recipeLabels = $model->attributeLabels();
$recipeTypesList = RecipeTypes::getSelectList('id', 'name');
$ingredientsList = Ingredient::getSelectList('id', 'name');
$measureUnitsList = MeasureUnit::getSelectList('name', 'name');

$ingredientModel = new RecipeIngredient();
$ingredientLabels = $ingredientModel->attributeLabels();
$timelineModel = new Timeline();
$timelineLabels = $timelineModel->attributeLabels();
$timelineEventModel = new TimelineEvent();
$timelineEventLabels = $timelineEventModel->attributeLabels();
?>

<?php
$form = ActiveForm::begin([
    'action' => $action ?: null,
    'method' => 'post',
    'options' => ['class' => 'recipeForm'],
])
?>
<?= $form->field($model, 'id', ['template' => '{input}'])->hiddenInput() ?>
<table class="recipeForm__recipeInfo">
    <tr>
        <td colspan="3">
            <?= $form
                ->field($model, 'name', ['template' => '{input}'])
                ->textInput(['placeholder' => $recipeLabels['name'], 'class' => 'input'])
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?= $form
                ->field($model, 'description', ['template' => '{input}'])
                ->textarea(['placeholder' => $recipeLabels['description'], 'class' => 'input'])
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <?= $form
                ->field($model, 'length', ['template' => '{input}'])
                ->textInput(['placeholder' => $recipeLabels['length'], 'class' => 'input', 'type' => 'number'])
            ?>
        </td>
        <td>
            <?= $form
                ->field($model, 'portions', ['template' => '{input}'])
                ->textInput(['placeholder' => $recipeLabels['portions'], 'class' => 'input', 'type' => 'number'])
            ?>
        </td>
        <td>
            <?= $form
                ->field($model, 'type_id', ['template' => '{input}'])
                ->listBox($recipeTypesList, ['size' => 1, 'class' => 'input'])
            ?>
        </td>
    </tr>
</table>
<div class="recipeForm__ingredients">
    <div class="recipeForm__timelinesTitle">
        <?= Yii::t('app', 'Ингредиенты') ?>
        <button class="btn btn_type_success recipeForm__ingredientsButton recipeForm__ingredientsButton_add"><?= Yii::t('app', 'Добавить ингредиент') ?></button>
    </div>
    <div class="recipeForm__ingredientsContent"></div>
</div>
<div class="recipeForm__timelines">
    <div class="recipeForm__timelinesTitle">
        <?= Yii::t('app', 'Временные шкалы') ?>
        <button class="btn btn_type_success recipeForm__timelinesButton recipeForm__timelinesButton_add"><?= Yii::t('app', 'Добавить временную шкалу') ?></button>
    </div>
    <div class="recipeForm__timelinesContent"></div>
</div>
<div class="recipeForm__buttons">
    <button type="submit" class="btn btn_type_success"><?= Yii::t('app', 'Сохранить') ?></button>
</div>
<?php ActiveForm::end() ?>

<div class="template recipeForm__ingredient" data-template="ingredient">
    <label class="recipeForm__ingredientIngredientId">
        <?= Html::listBox('Ingredient[ingredient_id][]', null, $ingredientsList, ['class' => 'input', 'size' => 1]) ?>
    </label>
    <label class="recipeForm__ingredientValue"><input type="number" name="Ingredient[value][]" class="input" placeholder="<?= Yii::t('app', $ingredientLabels['value']) ?>"></label>
    <label class="recipeForm__ingredientMeasureUnit">
        <?= Html::listBox('Ingredient[measure_unit][]', null, $measureUnitsList, ['class' => 'input', 'size' => 1]) ?>
    </label>
    <div class="recipeForm__ingredientButtons">
        <button class="btn btn_type_error btnDelete" data-parent=".recipeForm__ingredient" title="<?= Yii::t('app', 'Удалить') ?>">&times;</button>
    </div>
</div>
<div class="template recipeForm__timeline" data-template="timeline">
    <label class="recipeForm__timelineName"><input type="text" name="Timeline[{n}][name]" class="input" placeholder="<?= Yii::t('app', $timelineLabels['name']) ?>"></label>
    <div class="recipeForm__timelineEventsTitle">
        <?= Yii::t('app', 'События') ?>
        <button class="btn btn_type_success recipeForm__timelineEventsButton recipeForm__timelineEventsButton_add"><?= Yii::t('app', 'Добавить событие') ?></button>
    </div>
    <div class="recipeForm__timelineEvents">
        <div class="recipeForm__timelineEventsContent"></div>
        <div class="recipeForm__timelineButtons">
            <button class="btn btn_type_error btnDelete" data-parent=".recipeForm__timeline" title="<?= Yii::t('app', 'Удалить') ?>">&times;</button>
            <button class="btn btnMoveUp" data-parent=".recipeForm__timeline" title="<?= Yii::t('app', 'Передвинуть выше') ?>">&uarr;</button>
            <button class="btn btnMoveDown" data-parent=".recipeForm__timeline" title="<?= Yii::t('app', 'Передвинуть ниже') ?>">&darr;</button>
        </div>
    </div>
</div>
<div class="template recipeForm__timelineEvent" data-template="timelineEvent">
    <label class="recipeForm__timelineEventName"><input type="text" name="Timeline[{n}][Event][name][]" class="input" placeholder="<?= Yii::t('app', $timelineEventLabels['name']) ?>"></label>
    <label class="recipeForm__timelineEventTime"><input type="number" name="Timeline[{n}][Event][time][]" class="input" placeholder="<?= Yii::t('app', $timelineEventLabels['time']) ?>"></label>
    <label class="recipeForm__timelineEventDescription"><textarea name="Timeline[{n}][Event][description][]" class="input" placeholder="<?= Yii::t('app', $timelineEventLabels['description']) ?>"></textarea></label>
    <div class="recipeForm__timelineEventButtons">
        <button class="btn btn_type_error btnDelete" data-parent=".recipeForm__timelineEvent" title="<?= Yii::t('app', 'Удалить') ?>">&times;</button>
        <button class="btn btnMoveUp" data-parent=".recipeForm__timelineEvent" title="<?= Yii::t('app', 'Передвинуть выше') ?>">&uarr;</button>
        <button class="btn btnMoveDown" data-parent=".recipeForm__timelineEvent" title="<?= Yii::t('app', 'Передвинуть ниже') ?>">&darr;</button>
    </div>
</div>

<?php
if (!$model->isNewRecord) {
    $data = $model->toArray(
        ['id', 'name', 'description', 'length', 'portions', 'type_id'],
        ['recipeIngredients', 'timelines.name', 'timelines.timelineEvents']
    );
    $this->registerJs('loadRecipe(document.querySelector(".recipeForm"), ' . json_encode($data) . ');', View::POS_READY);
}