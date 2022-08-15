<?php

namespace app\models\traits;

trait SelectListTrait
{

    /**
     * @param mixed $id
     * @param mixed $name
     * @return array
     */
    public static function getSelectList(mixed $id = 'id', mixed $name = 'name', ?string $defaultValue = null): array
    {
        $list = [];
        if ($defaultValue !== null) {
            $list[''] = $defaultValue;
        }
        $values = static::find()->all();
        foreach ($values as $value) {
            if (is_callable($id)) {
                $valueId = $id($value);
            } else {
                $valueId = $value[$id];
            }
            if (is_callable($name)) {
                $valueName = $name($value);
            } else {
                $valueName = $value[$name];
            }
            $list[$valueId] = $valueName;
        }
        return $list;
    }

}