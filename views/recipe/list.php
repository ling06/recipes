<?php

use app\models\Recipe;
use yii\helpers\Url;

/**
 * @var Recipe[] $recipes
 */

?>

<?php if (empty($recipes)): ?>
    <div class="recipeList recipeList_empty"><?= Yii::t('app', 'Рецептов не найдено :(') ?></div>
<?php else: ?>
    <div class="recipeList">
        <?php foreach ($recipes as $recipe): ?>
            <a class="recipeList__recipe" href="<?= Url::to(['recipe/view', 'id' => $recipe->id, 'slug' => $recipe->slug]) ?>">
                <span class="recipeList__recipeName"><?= $recipe->name ?></span>
                <span class="recipeList__recipeDescription"><?= $recipe->description ?></span>
                <span class="recipeList__recipeLength"><?= $recipe->length ?>&nbsp;<?= Yii::t('app', 'мин') ?></span>
            </a>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
