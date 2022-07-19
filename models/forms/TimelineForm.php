<?php

namespace app\models\forms;

use app\components\Helper;
use app\models\Timeline;
use app\models\TimelineEvent;

class TimelineForm extends Timeline
{

    public array $Event = [];

    public function rules(): array
    {
        return [
            [['name'], 'safe'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {
        if (parent::save($runValidation, $attributeNames)) {
            if ($this->Event) {
                foreach (Helper::transpose($this->Event['name']) as $eventData) {
                    $event = new TimelineEvent($eventData);
                    $event->timeline_id = $this->id;
                    if (!$event->save()) {
                        $this->addError('Event', 'Ошибка сохранения события.');
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

}