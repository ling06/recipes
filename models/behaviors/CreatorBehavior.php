<?php
namespace app\models\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class CreatorBehavior extends Behavior
{

    public string $attribute = 'name';

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'setUserId',
        ];
    }

    public function setUserId($event)
    {
        $this->owner->{$this->attribute} = \Yii::$app->user->id ?? null;
    }

}