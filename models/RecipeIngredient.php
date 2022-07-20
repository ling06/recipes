<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\RecipeIngredientQuery;

/**
 * This is the model class for table "recipe_ingredients".
 *
 * @property int|null $recipe_id
 * @property int|null $ingredient_id
 * @property float|null $value
 * @property string|null $measure_unit
 *
 * @property Ingredient $ingredient
 * @property Recipe $recipe
 */
class RecipeIngredient extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'recipe_ingredients';
    }

    public static function primaryKey(): array
    {
        return ['recipe_id', 'ingredient_id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['recipe_id', 'ingredient_id'], 'integer'],
            [['value'], 'number'],
            [['measure_unit'], 'string', 'max' => 20],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredient::class, 'targetAttribute' => ['ingredient_id' => 'id']],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::class, 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'recipe_id' => Yii::t('app', 'Рецепт'),
            'ingredient_id' => Yii::t('app', 'Ингредиент'),
            'value' => Yii::t('app', 'Количество'),
            'measure_unit' => Yii::t('app', 'Измерение'),
        ];
    }

    /**
     * Gets query for [[Ingredient]].
     *
     * @return ActiveQuery
     */
    public function getIngredient(): ActiveQuery
    {
        return $this->hasOne(Ingredient::class, ['id' => 'ingredient_id']);
    }

    /**
     * Gets query for [[Recipe]].
     *
     * @return ActiveQuery
     */
    public function getRecipe(): ActiveQuery
    {
        return $this->hasOne(Recipe::class, ['id' => 'recipe_id']);
    }

    /**
     * {@inheritdoc}
     * @return RecipeIngredientQuery the active query used by this AR class.
     */
    public static function find(): RecipeIngredientQuery
    {
        return new RecipeIngredientQuery(static::class);
    }
}
