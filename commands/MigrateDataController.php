<?php

namespace app\commands;

use yii\console\Controller;

class MigrateDataController extends Controller
{

    public function actionBase()
    {
        \Yii::$app->db->createCommand()->batchInsert('measure_units', ['name'], [
            'мм',
            'см',
            'м',
            'мг',
            'г',
            'кг',
            'мл',
            'л',
            'шт',
            'ст. ложка',
            'ч. ложка',
        ]);
    }

}