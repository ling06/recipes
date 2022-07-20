<?php
namespace app\models\behaviors;

use yii\base\Behavior;
use yii\db\BaseActiveRecord;

class DeleteDependenciesBehavior extends Behavior
{

    public array $dependencies = [];

    public function events(): array
    {
        return [
            BaseActiveRecord::EVENT_BEFORE_DELETE => 'deleteDependencies',
        ];
    }

    public function deleteDependencies($event)
    {
        foreach ($this->dependencies as $dependency) {
            if ($this->owner->$dependency) {
                foreach ($this->owner->$dependency as $dependencyItem) {
                    $dependencyItem->delete();
                }
            }
        }
    }

}