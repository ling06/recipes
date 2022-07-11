<?php

use yii\db\Migration;

/**
 * Class m220710_182245_add_role_to_users
 */
class m220710_182245_add_role_to_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('users', 'role', $this->string(50));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('users', 'role');
    }

}
