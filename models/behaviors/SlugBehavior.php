<?php
namespace app\models\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class SlugBehavior extends Behavior
{

    public string $nameAttribute = 'name';
    public string $slugAttribute = 'slug';

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'setSlug',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'setSlug',
        ];
    }

    public function setSlug($event)
    {
        $this->owner->{$this->slugAttribute} = $this->owner::createSlug($this->owner->{$this->nameAttribute});
    }

}