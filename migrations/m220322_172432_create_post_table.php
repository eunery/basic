<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m220322_172432_create_post_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%post}}', array(
            'id' => $this->primaryKey(),
            'body' => $this->text(),
            'head' => $this->string(),
            'dateCreate' => $this->date(),
            'author' => $this->string(),
            'status' => $this->integer(),
            'image' => $this->string()->defaultValue(null),
            'views' => $this->integer()->defaultValue(0),
            'category_id' => $this->integer(),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%post}}');
    }
}
