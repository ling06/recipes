<?php
namespace app\models\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class TimestampBehavior extends Behavior
{

    public string $createdAtAttribute = 'created_at';
    public string $updatedAtAttribute = 'updated_at';
    public string $format = 'Y-m-d H:i:s';

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'setCreatedAt',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'setUpdatedAt',
        ];
    }

    public function setCreatedAt($event)
    {
        if ($this->createdAtAttribute) {
            $this->owner->{$this->createdAtAttribute} = date($this->format);
        }
    }

    public function setUpdatedAt($event)
    {
        if ($this->createdAtAttribute) {
            $this->owner->{$this->updatedAtAttribute} = date($this->format);
        }
    }

}