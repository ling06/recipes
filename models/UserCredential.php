<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use app\models\queries\UserCredentialQuery;

/**
 * This is the model class for table "user_credentials".
 *
 * @property int $user_id
 * @property string|null $type
 * @property string|null $value
 *
 * @property User $user
 */
class UserCredential extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user_credentials';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['type', 'value'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'type' => Yii::t('app', 'Type'),
            'value' => Yii::t('app', 'Value'),
        ];
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
     * @return UserCredentialQuery the active query used by this AR class.
     */
    public static function find(): UserCredentialQuery
    {
        return new UserCredentialQuery(static::class);
    }
}
