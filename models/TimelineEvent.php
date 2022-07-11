<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\TimelineEventQuery;

/**
 * This is the model class for table "timeline_events".
 *
 * @property int $id
 * @property int|null $timeline_id
 * @property int|null $time
 * @property string|null $name
 * @property string|null $description
 *
 * @property Timeline $timeline
 */
class TimelineEvent extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'timeline_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['timeline_id', 'time'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['timeline_id'], 'exist', 'skipOnError' => true, 'targetClass' => Timeline::class, 'targetAttribute' => ['timeline_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'timeline_id' => Yii::t('app', 'Timeline ID'),
            'time' => Yii::t('app', 'Time'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
        ];
    }

    /**
     * Gets query for [[Timeline]].
     *
     * @return ActiveQuery
     */
    public function getTimeline(): ActiveQuery
    {
        return $this->hasOne(Timeline::class, ['id' => 'timeline_id']);
    }

    /**
     * {@inheritdoc}
     * @return TimelineEventQuery the active query used by this AR class.
     */
    public static function find(): TimelineEventQuery
    {
        return new TimelineEventQuery(static::class);
    }
}
