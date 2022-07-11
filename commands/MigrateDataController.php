<?php

namespace app\commands;

use app\models\Recipe;
use Yii;
use app\components\Helper;
use yii\console\Controller;

class MigrateDataController extends Controller
{

    public function actionBase()
    {
        Yii::$app->db->createCommand()->batchInsert('measure_units', ['name'], [
            ['мм'],
            ['см'],
            ['м'],
            ['мг'],
            ['г'],
            ['кг'],
            ['мл'],
            ['л'],
            ['шт'],
            ['ст. ложка'],
            ['ч. ложка'],
        ])->execute();
    }

    public function actionAddFieldsToRecipes()
    {
        $recipes = Yii::$app->db->createCommand('select id, name from recipes')->queryAll();
        if ($recipes) {
            foreach ($recipes as $recipe) {
                $slug = Recipe::createSlug($recipe['name']);
                Yii::$app->db->createCommand()->update(
                    'recipes',
                    ['slug' => $slug],
                    ['id' => $recipe['id']]
                )->execute();
            }
        }

        Yii::$app->db->createCommand()->batchInsert('recipe_types', ['name'], [
            ['Завтрак'],
            ['Обед'],
            ['Ужин'],
            ['Перекус'],
            ['Напиток'],
        ])->execute();

        $recipeType = Yii::$app->db->createCommand('select id from recipe_types order by id ASC limit 1')->queryOne();
        if ($recipeType) {
            Yii::$app->db->createCommand()->update('recipes', ['type_id' => $recipeType['id']])->execute();
        }
    }

}