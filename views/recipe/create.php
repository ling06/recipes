<?php

use app\models\forms\RecipeCreateForm;
use yii\web\View;

/**
 * @var View $this
 * @var RecipeCreateForm $model
 */
?>

<h1><?= $this->title ?></h1>

<?= $this->context->renderPartial('_form', [
    'model' => $model,
]) ?>

