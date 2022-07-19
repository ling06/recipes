<?php

namespace app\models\forms;

use app\components\Helper;
use app\models\Recipe;
use app\models\RecipeIngredient;
use yii\helpers\VarDumper;

class RecipeCreateForm extends Recipe
{

    public array $Timeline = [];
    public array $Ingredient = [];

    public function rules(): array
    {
        return [
            [['name', 'description', 'length', 'portions', 'type'], 'safe'],
        ];
    }

    /**
     * @inheritDoc
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {
        if (parent::save($runValidation, $attributeNames)) {
            if ($this->Ingredient) {
                foreach (Helper::transpose($this->Ingredient) as $ingredientData) {
                    $ingredient = new RecipeIngredient($ingredientData);
                    $ingredient->recipe_id = $this->id;
                    if (!$ingredient->save()) {
                        $this->addError('Timeline', \Yii::t('app', 'Ошибка сохранения ингредиента.'));
                        return false;
                    }
                }
            }
            if ($this->Timeline) {
                foreach ($this->Timeline as $timeline) {
                    $timelineForm = new TimelineForm($timeline);
                    $timelineForm->recipe_id = $this->id;
                    if (!$timelineForm->save()) {
                        $this->addError('Timeline', \Yii::t('app', 'Ошибка сохранения временной шкалы.'));
                        return false;
                    }
                }
            }
            return true;
        }
        return false;
    }

}