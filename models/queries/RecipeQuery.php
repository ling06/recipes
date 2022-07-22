<?php

namespace app\models\queries;

use app\models\Recipe;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\app\models\Recipe]].
 *
 * @see \app\models\Recipe
 */
class RecipeQuery extends ActiveQuery
{

    public function isActive(): self
    {
        $this->andWhere(['status' => Recipe::STATUS_ACTIVE]);
        return $this;
    }

    public function isDeleted(): self
    {
        $this->andWhere(['status' => Recipe::STATUS_DELETED]);
        return $this;
    }

    public function isDraft(): self
    {
        $this->andWhere(['status' => Recipe::STATUS_DRAFT]);
        return $this;
    }

    public function isVisible(): self
    {
        $this->andWhere([
            'or',
            ['status' => Recipe::STATUS_ACTIVE],
            ['status' => Recipe::STATUS_DRAFT, 'user_id' => \Yii::$app->user->id ?? null],
        ]);
        return $this;
    }

}
