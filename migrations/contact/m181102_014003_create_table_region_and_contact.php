<?php

use yii\db\Query;

/**
 * 通用的地址模组 包括 contact 和 region 两个表
 */
class m181102_014003_create_table_region_and_contact extends yii\db\Migration
{
    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Region
        $this->createTable('{{%region}}', [
            'id' => $this->smallInteger(),
            'parent_id' => $this->smallInteger(),
            'name' => $this->string(45),
            'position' => $this->boolean()->notNull()->defaultValue(0),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-region', '{{%region}}', 'id');
        $this->addForeignKey(
            'fk-region-parent',
            '{{%region}}', 'parent_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // Contract
        $this->createTable('{{%contact}}', [
            'id' => $this->primaryKey()->comment('客户ID'),
            'category' => $this->boolean()->notNull(),
            'is_lite' => $this->boolean()->notNull()->defaultValue(1),
            'is_main' => $this->boolean()->notNull()->defaultValue(0),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'user_id' => $this->integer()->null(),
            'province_id' => $this->smallInteger()->null(),
            'city_id' => $this->smallInteger()->null(),
            'district_id' => $this->smallInteger()->null(),
            'name' => $this->string(45)->notNull()->comment('姓名'),
            'phone' => $this->string(20)->notNull()->comment('手机'),
            'address' => $this->string(100)->notNull()->comment('地址'),
            'alias' => $this->string(10)->null()->comment('别称'),
            'note' => $this->string(50)->null()->comment('备注'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-contact-user',
            '{{%contact}}', 'user_id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-province-region',
            '{{%contact}}', 'province_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-city-region',
            '{{%contact}}', 'city_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-district-region',
            '{{%contact}}', 'district_id',
            '{{%region}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-district-region', '{{%contact}}');
        $this->dropForeignKey('fk-city-region', '{{%contact}}');
        $this->dropForeignKey('fk-province-region', '{{%contact}}');
        $this->dropForeignKey('fk-contact-user', '{{%contact}}');
        $this->dropTable('{{%contact}}');

        // region
        $this->dropForeignKey('fk-region-parent', '{{%region}}');
        $this->dropTable('{{%region}}');

    }
}
