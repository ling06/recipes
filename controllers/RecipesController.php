<?php

namespace app\controllers;

use app\models\searchers\RecipeSearcher;
use yii\web\Controller;

class RecipesController extends Controller
{

    public function actionIndex(): string
    {
        $recipesProvider = (new RecipeSearcher())->search();
        $recipes = $recipesProvider->query
            ->offset($recipesProvider->pagination->offset)
            ->limit($recipesProvider->pagination->limit)
            ->all();
        return $this->render('//recipe/list', [
            'recipes' => $recipes,
        ]);
    }

}