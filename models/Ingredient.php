<?php

namespace app\models;

use app\models\traits\SelectListTrait;
use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\IngredientQuery;

/**
 * This is the model class for table "ingredients".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $link
 *
 * @property RecipeIngredient[] $recipeIngredients
 * @property User $user
 */
class Ingredient extends ActiveRecord
{
    use SelectListTrait;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'ingredients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id'], 'integer'],
            [['created_at', 'link'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => Yii::t('app', 'User ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'link' => Yii::t('app', 'Link'),
        ];
    }

    /**
     * Gets query for [[RecipeIngredients]].
     *
     * @return ActiveQuery
     */
    public function getRecipeIngredients(): ActiveQuery
    {
        return $this->hasMany(RecipeIngredient::class, ['ingredient_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return ActiveQuery
     */
    public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return IngredientQuery the active query used by this AR class.
     */
    public static function find(): IngredientQuery
    {
        return new IngredientQuery(static::class);
    }
}
