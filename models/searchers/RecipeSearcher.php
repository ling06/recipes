<?php

namespace app\models\searchers;

use app\models\Recipe;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

class RecipeSearcher extends Recipe
{

    public int $status;

    public function search(): ActiveDataProvider
    {
        $query = Recipe::find()
            ->andFilterWhere(['status' => $this->status]);
        $pagination = new Pagination(['totalCount' => $query->count()]);
        return new ActiveDataProvider([
            'query' => $query,
            'pagination' => $pagination,
        ]);
    }

}