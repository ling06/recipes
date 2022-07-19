<?php

namespace app\models;

use Yii;
use yii\base\InvalidArgumentException;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\queries\UserQuery;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string|null $login
 * @property string|null $password
 * @property string|null $role
 *
 * @property Ingredient[] $ingredients
 * @property Recipe[] $recipes
 * @property UserCredential $userCredential
 */
class User extends ActiveRecord implements IdentityInterface
{

    public const SCENARIO_CHANGE_PASSWORD = 'changePassword';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'users';
    }

    public function scenarios(): array
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_CHANGE_PASSWORD] = ['password'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['login'], 'string', 'max' => 255],
            [['password'], 'string', 'max' => 60],
            [['role'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'login' => Yii::t('app', 'Логин'),
            'password' => Yii::t('app', 'Пароль'),
            'role' => Yii::t('app', 'Роль'),
        ];
    }

    public function beforeSave($insert): bool
    {
        if ($this->scenario === self::SCENARIO_CHANGE_PASSWORD && $this->password) {
            $this->password = Yii::$app->security->generatePasswordHash($this->password);
        } else {
            $this->password = $this->oldAttributes['password'] ?? null;
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Ingredients]].
     *
     * @return ActiveQuery
     */
    public function getIngredients(): ActiveQuery
    {
        return $this->hasMany(Ingredient::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Recipes]].
     *
     * @return ActiveQuery
     */
    public function getRecipes(): ActiveQuery
    {
        return $this->hasMany(Recipe::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[UserCredential]].
     *
     * @return ActiveQuery
     */
    public function getUserCredential(): ActiveQuery
    {
        return $this->hasOne(UserCredential::class, ['user_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UserQuery the active query used by this AR class.
     */
    public static function find(): UserQuery
    {
        return new UserQuery(static::class);
    }

    public static function findIdentity($id): ?User
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null): ?User
    {
        return null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey(): int
    {
        return $this->id;
    }

    // todo: добавить auth_key, когда понадобится
    public function validateAuthKey($authKey): bool
    {
        return $this->id === $authKey;
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public static function findByUsername(string $username): ?self
    {
        return self::findOne(['login' => $username]);
    }

}
