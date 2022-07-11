<?php

use yii\db\Migration;

class m220705_164754_add_fields_to_recipes extends Migration
{

    public function safeUp()
    {
        $this->createTable('recipe_types', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100),
        ]);

        $this->addColumn('recipes', 'slug', $this->text());
        $this->addColumn('recipes', 'type_id', $this->integer());
        $this->addForeignKey('recipes_type_id_fkey', 'recipes', 'type_id', 'recipe_types', 'id');
    }

    public function safeDown()
    {
        $this->dropForeignKey('recipes_type_id_fkey', 'recipes');
        $this->dropColumn('recipes', 'type_id');
        $this->dropColumn('recipes', 'slug');
        $this->dropTable('recipe_types');
    }

}
