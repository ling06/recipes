<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\MeasureUnitQuery;

/**
 * This is the model class for table "measure_units".
 *
 * @property int $id
 * @property string|null $name
 */
class MeasureUnit extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'measure_units';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['name'], 'string', 'max' => 20],
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
     * {@inheritdoc}
     * @return MeasureUnitQuery the active query used by this AR class.
     */
    public static function find(): MeasureUnitQuery
    {
        return new MeasureUnitQuery(static::class);
    }
}
