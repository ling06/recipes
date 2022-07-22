<?php

use yii\db\Migration;

/**
 * Class m220722_122530_add_status_to_recipes
 */
class m220722_122530_add_status_to_recipes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('recipes', 'status', $this->tinyInteger()->unsigned()->defaultValue(1));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('recipes', 'status');
    }

}
