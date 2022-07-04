<?php
use yii\db\Migration;

class m220701_125544_base extends Migration
{

    public function safeUp()
    {
        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'login' => $this->string(255),
            'password' => $this->string(32),
        ]);

        $this->createTable('user_credentials', [
            'user_id' => $this->primaryKey(),
            'type' => 'ENUM("password", "email", "vk")',
            'value' => $this->text(),
        ]);
        $this->addForeignKey('user_credentials_user_id_fkey', 'user_credentials', 'user_id', 'users', 'id');

        $this->createTable('recipes', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'description' => $this->text(),
            'length' => $this->smallInteger()->unsigned(),
            'portions' => $this->tinyInteger()->unsigned(),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ]);
        $this->addForeignKey('recipes_user_id_fkey', 'recipes', 'user_id', 'users', 'id');

        $this->createTable('timelines', [
            'id' => $this->primaryKey(),
            'recipe_id' => $this->integer(),
            'name' => $this->string(255),
        ]);
        $this->addForeignKey('timelines_recipe_id_fkey', 'timelines', 'recipe_id', 'recipes', 'id');

        $this->createTable('timeline_events', [
            'id' => $this->primaryKey(),
            'timeline_id' => $this->integer(),
            'time' => $this->smallInteger()->unsigned(),
            'name' => $this->string(255),
            'description' => $this->text(),
        ]);
        $this->addForeignKey('timeline_events_timeline_id_fkey', 'timeline_events', 'timeline_id', 'timelines', 'id');

        $this->createTable('ingredients', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
            'user_id' => $this->integer(),
            'created_at' => $this->dateTime(),
        ]);
        $this->addForeignKey('ingredients_user_id_fkey', 'ingredients', 'user_id', 'users', 'id');

        $this->createTable('recipe_ingredients', [
            'recipe_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
            'value' => $this->float(),
            'measure_unit' => $this->string(20),
        ]);
        $this->addForeignKey('recipe_ingredients_recipe_id_fkey', 'recipe_ingredients', 'recipe_id', 'recipes', 'id');
        $this->addForeignKey('recipe_ingredients_ingredient_id_fkey', 'recipe_ingredients', 'ingredient_id', 'ingredients', 'id');

        $this->createTable('measure_units', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20),
        ]);
    }

    public function safeDown()
    {
        echo "m220701_125544_base cannot be reverted.\n";
        return false;
    }

}
