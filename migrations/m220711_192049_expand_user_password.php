<?php

use yii\db\Migration;

/**
 * Class m220711_192049_expand_user_password
 */
class m220711_192049_expand_user_password extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('users', 'password', $this->string(60));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('users', 'password', $this->string(32));
    }

}
