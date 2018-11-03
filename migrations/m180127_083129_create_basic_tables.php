<?php

/**
 * Class m180127_083129_create_basic_tables
 *
 * 新建表格： lookup, taxonomy, meaid, activity, user, directive, option
 */
class m180127_083129_create_basic_tables extends yii\db\Migration
{
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            ['user-status', 1, 1, '正常'],
            ['user-status', 0, 2, '冻结'],
            ['boolean', 1, 0, '是'],
            ['boolean', 0, 1, '否'],
        ],
    ];

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /**
         * User
         */
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()->comment('用户名'),
            'mobile_phone' => $this->string(11)->unique()->comment('手机号'),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'access_token' => $this->string()->unique(),
            'email' => $this->string()->unique()->comment('邮箱地址'),
            'status' => $this->boolean()->notNull()->defaultValue(1)->comment('状态'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        // 导入测试账户信息，默认密码：123456
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'password_hash' => '$2y$13$qrJfT4ExDCuDclDCqDRRL.FypbYfl98ot.mgmyElho39AcPSZfQtG',
            'password_reset_token' => '$2y$13$BnT.whUJcDH9q5vMnox2We3YtYJnv9wyUQb4vZyS6.HfA2NPIzIL.',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        /**
         * Lookup
         */
        $this->createTable('{{%lookup}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(90)->notNull(),
            'name' => $this->string(50)->notNull(),
            'code' => $this->smallInteger()->notNull(),
            'position' => $this->smallInteger()->notNull(),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);
        $this->batchInsert('{{%lookup}}', $this->lookups[0], $this->lookups[1]);

        /**
         * Taxonomy
         */
        $this->createTable('{{%taxonomy}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(50)->notNull()->comment('类别'),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'slug' => $this->string(50),
            'parent_id' => $this->bigInteger()->comment('上级目录'),
            'visible' => $this->boolean()->notNull()->defaultValue(1)->comment('是否可见'),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-taxonomy-parent',
            '{{%taxonomy}}', 'parent_id',
            '{{%taxonomy}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        /**
         * 活动记录
         */
        $this->createTable('{{%activity}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(50)->notNull()->comment('类别'),
            'reference' => $this->bigInteger()->comment('参考模型ID'),
            'action' => $this->string(100)->notNull()->comment('动作'),
            'note' => $this->text(),
            'created_at' => $this->integer(),
            'created_by' => $this->integer(),
        ], $this->tableOptions);

        /**
         * 指令表
         * category: 'app', 'user', 'plugin
         * format: 'integer', 'decimal', 'switch', 'array', 'json'
         */
        $this->createTable('{{%directive}}', [
            'code' => $this->string(45)->notNull()->comment('指令符'),
            'name' => $this->string(100)->notNull()->comment('名称'),
            'category' => $this->string(45)->notNull()->comment('类别'),
            'format' => $this->string(10)->notNull()->comment('值格式'),
            'description' => $this->text()->comment('说明'),
            'position' => $this->boolean()->notNull()->comment('位置排序'),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'status' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);
        $this->addPrimaryKey('pk-directive', '{{%directive}}', 'code');
        /**
         * 选项表
         */
        $this->createTable('{{%option}}', [
            'id' => $this->bigPrimaryKey(),
            'directive_code' => $this->string(45)->notNull(),
            'value' => $this->string()->notNull(),
            'user_id' => $this->integer(),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-option-user',
            '{{%option}}', 'user_id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-option-directive',
            '{{%option}}', 'directive_code',
            '{{%directive}}', 'code',
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

        $this->dropForeignKey('fk-option-user', '{{%option}}');
        $this->dropForeignKey('fk-option-directive', '{{%option}}');
        $this->dropTable('{{%option}}');
        $this->dropTable('{{%directive}}');

        $this->dropTable('{{%lookup}}');
        $this->dropTable('{{%activity}}');
        $this->dropTable('{{%user}}');
    }
}
