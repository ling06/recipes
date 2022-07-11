<?php

use yii\db\Migration;

/**
 * Class m220711_125850_create_user_permissions
 */
class m220711_125850_create_user_permissions extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user_permissions', [
            'user_id' => $this->integer(),
            'permission' => $this->string(255),
        ]);
        $this->addPrimaryKey('user_permissions_pkey', 'user_permissions', ['user_id', 'permission']);
        $this->addForeignKey('user_permissions_user_id_fkey', 'user_permissions', 'user_id', 'users', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user_permissions');
    }

}
