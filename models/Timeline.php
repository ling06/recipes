<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\TimelineQuery;

/**
 * This is the model class for table "timelines".
 *
 * @property int $id
 * @property int|null $recipe_id
 * @property string|null $name
 * @property int $sort
 *
 * @property Recipe $recipe
 * @property TimelineEvent[] $timelineEvents
 */
class Timeline extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'timelines';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['recipe_id', 'sort'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['recipe_id'], 'exist', 'skipOnError' => true, 'targetClass' => Recipe::class, 'targetAttribute' => ['recipe_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'recipe_id' => Yii::t('app', 'Recipe ID'),
            'name' => Yii::t('app', 'Название'),
            'sort' => Yii::t('app', 'Сортировка'),
        ];
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
     * Gets query for [[TimelineEvents]].
     *
     * @return ActiveQuery
     */
    public function getTimelineEvents(): ActiveQuery
    {
        return $this->hasMany(TimelineEvent::class, ['timeline_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return TimelineQuery the active query used by this AR class.
     */
    public static function find(): TimelineQuery
    {
        return new TimelineQuery(static::class);
    }
}
