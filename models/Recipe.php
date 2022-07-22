<?php

namespace app\models;

use app\components\Helper;
use app\models\behaviors\CreatorBehavior;
use app\models\behaviors\DeleteDependenciesBehavior;
use app\models\behaviors\SlugBehavior;
use app\models\behaviors\TimestampBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\db\ActiveRecord;
use yii\db\ActiveQuery;
use app\models\queries\RecipeQuery;

/**
 * This is the model class for table "recipes".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $description
 * @property int|null $length
 * @property int|null $portions
 * @property string|null $slug
 * @property int|null $type_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property int $status
 *
 * @property RecipeIngredient[] $recipeIngredients
 * @property Ingredient[] $ingredients
 * @property Timeline[] $timelines
 * @property User $user
 */
class Recipe extends ActiveRecord
{

    public const STATUS_ACTIVE = 1;
    public const STATUS_DELETED = 2;
    public const STATUS_DRAFT = 3; // @todo

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'recipes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'length', 'portions'], 'integer'],
            [['name', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
            [['type', 'status'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'name' => Yii::t('app', 'Название'),
            'description' => Yii::t('app', 'Описание'),
            'length' => Yii::t('app', 'Длительность, мин'),
            'portions' => Yii::t('app', 'Кол-во порций'),
            'type_id' => Yii::t('app', 'Тип блюда'),
            'slug' => Yii::t('app', 'Slug'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'status' => Yii::t('app', 'Статус'),
        ];
    }

    public function extraFields(): array
    {
        return ['recipeIngredients', 'ingredients', 'timelines', 'user'];
    }

    public function behaviors(): array
    {
        return [
            'slug' => [
                'class' => SlugBehavior::class,
                'nameAttribute' => 'name',
                'slugAttribute' => 'slug',
            ],
            'user' => [
                'class' => CreatorBehavior::class,
                'attribute' => 'user_id',
            ],
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            'deleteDependencies' => [
                'class' => DeleteDependenciesBehavior::class,
                'dependencies' => ['recipeIngredients', 'timelines'],
            ],
        ];
    }

    /**
     * Gets query for [[RecipeIngredients]].
     *
     * @return ActiveQuery
     */
    public function getRecipeIngredients(): ActiveQuery
    {
        return $this->hasMany(RecipeIngredient::class, ['recipe_id' => 'id']);
    }

    /**
     * Gets query for [[RecipeIngredients]].
     *
     * @return ActiveQuery
     */
    public function getIngredients(): ActiveQuery
    {
        return $this->hasMany(Ingredient::class, ['id' => 'ingredient_id'])->via('recipeIngredients');
    }

    /**
     * Gets query for [[Timelines]].
     *
     * @return ActiveQuery
     */
    public function getTimelines(): ActiveQuery
    {
        return $this->hasMany(Timeline::class, ['recipe_id' => 'id'])->orderBy(['sort' => SORT_ASC]);
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
     * @return RecipeQuery the active query used by this AR class.
     */
    public static function find(): RecipeQuery
    {
        return new RecipeQuery(static::class);
    }

    public static function createSlug(string $name): string
    {
        $name = preg_replace('/[^\w ]/', '', Helper::transliterate($name ?? ''));
        $name = str_replace(' ', '_', $name);
        return $name;
    }

    public function deleteDependencies(): self
    {
        foreach (['recipeIngredients', 'timelines'] as $dependency) {
            if ($this->$dependency) {
                foreach ($this->$dependency as $dependencyItem) {
                    $dependencyItem->delete();
                }
            }
        }
        return $this;
    }

    public function canBeUpdated(?int $userId = null): bool
    {
        if ($userId) {
            $user = User::findOne($userId);
            if (!$user) return false;
            return \Yii::$app->authManager->checkAccess($userId, 'recipe_update_all') || $this->user_id === $userId;
        }
        return Yii::$app->user->can('recipe_update_all') || $this->user_id === (Yii::$app->user->id ?? null);
    }

    public function canBeDeleted(?int $userId = null): bool
    {
        if ($userId) {
            $user = User::findOne($userId);
            if (!$user) return false;
            return \Yii::$app->authManager->checkAccess($userId, 'recipe_delete_all') || $this->user_id === $userId;
        }
        return Yii::$app->user->can('recipe_delete_all') || $this->user_id === (Yii::$app->user->id ?? null);
    }

    public function deleteSoft(): bool
    {
        $this->status = self::STATUS_DELETED;
        return $this->save();
    }

    public function restore(): bool
    {
        $this->status = self::STATUS_ACTIVE;
        return $this->save();
    }
}
