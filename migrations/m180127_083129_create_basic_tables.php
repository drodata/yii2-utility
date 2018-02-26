<?php

/**
 * Class m180127_083129_create_basic_tables
 *
 * 新建表格： lookup, taxonomy, user, extension, option
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
            'username' => $this->string()->notNull()->unique(),
            'mobile_phone' => $this->string(11)->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'access_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'status' => $this->boolean()->notNull()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $this->tableOptions);

        $columnComments = [
            'username' => '用户名',
            'mobile_phone' => '手机号',
            'email' => '邮箱地址',
            'status' => '状态',
            'created_at' => '创建时间',
        ];
        foreach ($columnComments as $column => $comment) {
            $this->addCommentOnColumn('{{%user}}', $column, $comment);
        }

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

        /**
         * Taxonomy
         */
        $this->createTable('{{%taxonomy}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->string(50)->notNull(),
            'name' => $this->string(50)->notNull(),
            'slug' => $this->string(50),
            'parent_id' => $this->bigInteger(),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);

        $columnComments = [
            'type' => '类别',
            'name' => '名称',
            'parent_id' => '上级目录',
            'visible' => '是否可见',
        ];
        foreach ($columnComments as $column => $comment) {
            $this->addCommentOnColumn('{{%taxonomy}}', $column, $comment);
        }

        $this->addForeignKey(
            'fk-taxonomy-parent',
            '{{%taxonomy}}', 'parent_id',
            '{{%taxonomy}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        $this->batchInsert('{{%lookup}}', $this->lookups[0], $this->lookups[1]);

        /**
         * 选项表
         *
         * type: 'conf', 'pref'
         * scope: 'app', 'user', 'plugin
         * format: 'integer', 'decimal', 'boolean', 'array', 'json'
         */
        $this->createTable('{{%option}}', [
            'id' => $this->primaryKey(),

            'scope' => $this->string(10)->notNull(),
            'user_id' => $this->integer(),
            'plugin_id' => $this->integer(),

            'type' => $this->string(5)->notNull(),
            'name' => $this->string()->notNull()->unique(),
            'directive' => $this->string(100)->notNull()->unique()->comment('指令符'),
            'format' => $this->string(20)->notNull(),
            'value' => $this->string()->notNull(),
            'description' => $this->text(),
        ], $this->tableOptions);

        /**
         * 插件表
         *
         */
        $this->createTable('{{%plugin}}', [
            'id' => $this->primaryKey(),
            'type' => $this->boolean()->notNull(),
            'name' => $this->string(100)->notNull()->unique(),
            'directive' => $this->string(100)->notNull()->unique()->comment('指令符'),
            'description' => $this->text(),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'status' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);

        $this->addForeignKey(
            'fk-option-user',
            '{{%option}}', 'user_id',
            '{{%user}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-option-plugin',
            '{{%option}}', 'plugin_id',
            '{{%plugin}}', 'id',
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
		$this->dropForeignKey('fk-option-plugin', '{{%option}}');
		$this->dropTable('{{%option}}');

		$this->dropTable('{{%plugin}}');
		$this->dropTable('{{%lookup}}');
		$this->dropTable('{{%user}}');
    }
}
