<?php

namespace app\controllers;

use app\models\Recipe;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class RecipeController extends Controller
{

    public function actionView($id, $slug)
    {
        $recipe = Recipe::find()->where([
            'id' => $id,
            'slug' => $slug,
        ])->one();
        if (!$recipe) {
            throw new NotFoundHttpException();
        }
        return $this->render('view', [
            'recipe' => $recipe,
        ]);
    }

}