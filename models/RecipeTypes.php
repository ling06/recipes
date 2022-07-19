<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\RecipeTypesQuery;
use app\models\traits\SelectListTrait;

/**
 * This is the model class for table "recipe_types".
 *
 * @property int $id
 * @property string|null $name
 *
 * @property Recipe[] $recipes
 */
class RecipeTypes extends ActiveRecord
{
    use SelectListTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'recipe_types';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return ActiveQuery
     */
    public function getRecipes(): ActiveQuery
    {
        return $this->hasMany(Recipe::class, ['type_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return RecipeTypesQuery the active query used by this AR class.
     */
    public static function find(): RecipeTypesQuery
    {
        return new RecipeTypesQuery(static::class);
    }
}
