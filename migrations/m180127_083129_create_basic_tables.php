<?php

/**
 * Class m180127_083129_create_basic_tables
 */
class m180127_083129_create_basic_tables extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%taxonomy}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(50)->notNull(),
            'name' => $this->string(50)->notNull(),
            'slug' => $this->string(50),
            'parent_id' => $this->bigInteger(),
            'visible' => $this->boolean(),
        ], $this->tableOptions);
        $this->addForeignKey(
            'fk-taxonomy-parent',
            '{{%taxonomy}}', 'parent_id',
            '{{%taxonomy}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropForeignKey('fk-taxonomy-parent', '{{%taxonomy}}');
		$this->dropTable('{{%taxonomy}}');
    }
}
