<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_permissions".
 *
 * @property int $user_id
 * @property string $permission
 *
 * @property User $user
 */
class UserPermissions extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'user_permissions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'permission'], 'required'],
            [['user_id'], 'integer'],
            [['permission'], 'string', 'max' => 255],
            [['user_id', 'permission'], 'unique', 'targetAttribute' => ['user_id', 'permission']],
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
            'permission' => Yii::t('app', 'Permission'),
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
}
