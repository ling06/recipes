<?php

use yii\db\Migration;

class m220704_084735_base_add extends Migration
{

    public function safeUp()
    {
        $this->addColumn('timelines', 'sort', $this->smallInteger()->unsigned());
    }

    public function safeDown()
    {
        echo "m220704_084735_base_add cannot be reverted.\n";
        return false;
    }

}
