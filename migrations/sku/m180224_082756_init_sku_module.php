<?php

/**
 * Class m180224_082756_init_sku_module
 *
 * 表格: brand, spu, sku, property, specification, currency, rate
 */
class m180224_082756_init_sku_module extends yii\db\Migration
{
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            ['spu-mode', 1, 1, '简易'],
            ['spu-mode', 2, 2, '严格'],
            ['spu-type', 1, 1, '婴儿奶粉'],
        ],
    ];
    // SPU 属性. 存储在 taxonomy 表内
    public $properties = [
        ['type', 'name'],
        [
            ['spu-property', '规格'],
            ['spu-property', '颜色'],
            ['spu-property', '尺码'],
        ],
    ];

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique()->comment('名称'),
            'alias' => $this->string()->unique()->comment('别名'),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
        ], $this->tableOptions);

        $this->createTable('{{%currency}}', [
            'code' => $this->char(3)->comment('编码'),
            'name' => $this->string(50)->notNull()->comment('名称'),
            'symbol' => $this->string(20)->comment('符号'),
            'PRIMARY KEY (code)'
        ], $this->tableOptions);

        $this->batchInsert('{{%currency}}', ['code', 'name', 'symbol'], [
            ['CNY', '人民币', '￥'],
            ['USD', '美元', '$'],
        ]);

        $this->createTable('{{%rate}}', [
            'date' => $this->date()->comment('日期'),
            'currency' => $this->char(3)->notNull()->comment('币种'),
            'value' => $this->decimal(8, 4)->notNull()->comment('汇率'),
            'PRIMARY KEY ([[date]], [[currency]])'
        ], $this->tableOptions);

        $this->createTable('{{%spu}}', [
            'id' => $this->bigPrimaryKey(),
            'mode' => $this->boolean()->notNull()->comment('模式'),
            'type' => $this->boolean()->notNull()->comment('类别'),
            'name' => $this->string()->notNull()->comment('名称'),
            'status' => $this->boolean()->notNull()->comment('状态'),
            'visible' => $this->boolean()->notNull()->defaultValue(1),
            'brand_id' => $this->integer()->comment('品牌'),
            'description' => $this->string()->comment('简介'),
            'introduction' => $this->text()->comment('详细介绍'),
        ], $this->tableOptions);
        $this->addForeignKey(
            'fk-spu-brand',
            '{{%spu}}', 'brand_id',
            '{{%brand}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // property
        $this->createTable('{{%property}}', [
            'id' => $this->bigPrimaryKey(),
            'spu_id' => $this->bigInteger()->notNull(),
            'taxonomy_id' => $this->bigInteger()->notNull(),
        ], $this->tableOptions);
        $this->addForeignKey(
            'fk-property-spu',
            '{{%property}}', 'spu_id',
            '{{%spu}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-property-taxonomy',
            '{{%property}}', 'taxonomy_id',
            '{{%taxonomy}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        // specification
        $this->createTable('{{%specification}}', [
            'id' => $this->bigPrimaryKey(),
            'property_id' => $this->bigInteger()->notNull(),
            'taxonomy_id' => $this->bigInteger()->notNull(),
        ], $this->tableOptions);
        $this->addForeignKey(
            'fk-specification-property',
            '{{%specification}}', 'property_id',
            '{{%property}}', 'id',
            'NO ACTION', 'NO ACTION'
        );
        $this->addForeignKey(
            'fk-specification-taxonomy',
            '{{%specification}}', 'taxonomy_id',
            '{{%taxonomy}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        $this->createTable('{{%sku}}', [
            'id' => $this->bigPrimaryKey(),
            'spu_id' => $this->bigInteger()->notNull(),

            'name' => $this->string()->notNull()->comment('名称'),
            'status' => $this->boolean()->notNull()->comment('状态'),
            'visible' => $this->boolean()->notNull()->defaultValue(1),

            'stock' => $this->integer()->comment('库存'),
            'threshold' => $this->smallInteger()->comment('库存预警值'),
            'description' => $this->string()->comment('简介'),
            'introduction' => $this->text()->comment('详细介绍'),
        ], $this->tableOptions);
        $this->addForeignKey(
            'fk-sku-spu',
            '{{%sku}}', 'spu_id',
            '{{%spu}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        $this->batchInsert('{{%lookup}}', $this->lookups[0], $this->lookups[1]);
        $this->batchInsert('{{%taxonomy}}', $this->properties[0], $this->properties[1]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
		$this->dropForeignKey('fk-sku-spu', '{{%sku}}');
		$this->dropTable('{{%sku}}');

		$this->dropForeignKey('fk-specification-taxonomy', '{{%specification}}');
		$this->dropForeignKey('fk-specification-property', '{{%specification}}');
		$this->dropTable('{{%specification}}');

		$this->dropForeignKey('fk-property-taxonomy', '{{%property}}');
		$this->dropForeignKey('fk-property-spu', '{{%property}}');
		$this->dropTable('{{%property}}');

		$this->dropForeignKey('fk-spu-brand', '{{%spu}}');
		$this->dropTable('{{%spu}}');

		$this->dropTable('{{%brand}}');
		$this->dropTable('{{%rate}}');
		$this->dropTable('{{%currency}}');

        $this->delete('{{%lookup}}', ['type' => ['spu-mode', 'spu-type']]);
        $this->delete('{{%taxonomy}}', ['type' => ['spu-property']]);
    }
}
