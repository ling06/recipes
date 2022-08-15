<?php

namespace app\models\searchers;

use app\models\Recipe;
use app\models\RecipeIngredient;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\db\ActiveQuery;

class RecipeSearcher extends Recipe
{

    public $ingredient_id;

    public function rules(): array
    {
        return [
            [['name', 'ingredient_id', 'type_id'], 'safe'],
        ];
    }

    public function applyIngredientSearch(ActiveQuery $query)
    {
        $query
            ->leftJoin(['recipe_ingredients' => RecipeIngredient::tableName()], 'recipe_ingredients.recipe_id = recipe.id')
            ->andWhere(['recipe_ingredients.ingredient_id' => $this->ingredient_id]);
    }

    public function search(): ActiveDataProvider
    {
        $query = Recipe::find()
            ->alias('recipe')
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['status' => $this->status]);

        if ($this->ingredient_id) {
            $this->applyIngredientSearch($query);
        }

        $pagination = new Pagination(['totalCount' => $query->count()]);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
        ]);
    }

}