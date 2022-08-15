<?php
/**
 * @var $this \yii\web\View
 */

use app\components\Helper;
use app\models\Ingredient;
use app\models\RecipeTypes;
use app\models\searchers\RecipeSearcher;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$model = new RecipeSearcher();
$model->load(Yii::$app->request->get());
$modelLabels = $model->attributeLabels();
$ingredients = Ingredient::getSelectList();
?>

<?php
$form = ActiveForm::begin([
    'method' => 'get',
    'options' => ['class' => 'recipeSearchForm'],
    'action' => [Helper::getBaseUrl()],
    'fieldConfig' => [
        'template' => '{input}',
    ],
]);
?>

    <div class="recipeSearchForm__header classToggle" data-class="recipeSearchForm_opened">
        <i class="fa fa-filter"></i>
        <?= Yii::t('app', 'Форма поиска рецептов') ?>
    </div>
    <div class="recipeSearchForm__content">

        <div class="recipeSearchForm__row">
            <div class="recipeSearchForm__rowTitle"><?= Yii::t('app', 'Название рецепта') ?></div>
            <div class="recipeSearchForm__rowInput">
                <?= $form
                    ->field($model, 'name')
                    ->textInput(['placeholder' => $modelLabels['name'], 'class' => 'input'])
                ?>
            </div>
        </div>
        <div class="recipeSearchForm__row">
            <div class="recipeSearchForm__rowTitle"><?= Yii::t('app', 'Ингредиент') ?></div>
            <div class="recipeSearchForm__rowInput">
                <?= $form
                    ->field($model, 'ingredient_id')
                    ->widget(Select2::class, [
                        'data' => $ingredients,
                        'showToggleAll' => false,
                        'options' => [
                            'multiple' => true,
                            'placeholder' => Yii::t('app', 'Любые'),
                        ],
                    ])
                ?>
            </div>
        </div>
        <div class="recipeSearchForm__row">
            <div class="recipeSearchForm__rowTitle"><?= Yii::t('app', 'Тип блюда') ?></div>
            <div class="recipeSearchForm__rowInput">
                <?= $form
                    ->field($model, 'type_id')
                    ->widget(Select2::class, [
                        'data' => RecipeTypes::getSelectList('id', 'name', Yii::t('app', 'Любой')),
                        'hideSearch' => true,
                    ])
                ?>
            </div>
        </div>
        <div class="recipeSearchForm__row">
            <div class="recipeSearchForm__rowInput">
                <?= Html::submitButton(Yii::t('app', 'Искать'), ['class' => 'btn btn_type_success']) ?>
            </div>
        </div>

    </div>

<?php ActiveForm::end() ?>