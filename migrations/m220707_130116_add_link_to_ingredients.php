<?php

use yii\db\Migration;

/**
 * Class m220707_130116_add_link_to_ingredients
 */
class m220707_130116_add_link_to_ingredients extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('ingredients', 'link', $this->text());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('ingredients', 'link');
    }

}
