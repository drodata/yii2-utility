<?php
/**
 * This view is used by console/controllers/MigrateController.php.
 *
 * 默认的模板不太好用，命令中的 `--fields` 参数不太好用。
 * 还不如已注释形式呈现，打开后再修改。
 *
 * 使用： 在 console configuration 内重定向模板文件路径至本文件
 * 
 * ```php
 * return [
 *     ...
 *     'controllerMap' => [
 *         'migrate' => [
 *             'class' => 'yii\console\controllers\MigrateController',
 *             'templateFile' => '@drodata/views/migration.php',
 *         ],
 *     ],
 * ];
 * ```
 * 
 * 之后执行 `./yii migrate/create example` 即可使用此文件作为 migration 模板。
 *
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name without namespace */
/* @var $namespace string the new migration class namespace */

echo "<?php\n";
if (!empty($namespace)) {
    echo "\nnamespace {$namespace};\n";
}
?>

use yii\db\Query;

/**
 * Class <?= $className . "\n" ?>
 */
class <?= $className ?> extends yii\db\Migration
{
    public $lookups = [
        ['type', 'code', 'position', 'name'],
        [
            ['status', 1, 1, ''],
        ],
    ];

    public $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        /*
        $this->createTable('{{%TABLE}}', [
            'id' => $this->bigPrimaryKey(),
            'type' => $this->smallInteger(3)->notNull()->comment(''),
            'amount' => $this->decimal(10,2)->notNull()->comment(''),
            'seller_id' => $this->integer()->comment(''),

            'status' => $this->boolean()->notNull()->comment('状态'),
            'note' => $this->string()->comment('备注'),
            'created_at' => $this->integer()->comment('创建时间'),
            'created_by' => $this->integer()->comment('申请人'),
            'updated_at' => $this->integer()->comment('修改时间'),
            'updated_by' => $this->integer()->comment('修改人'),
        ], $this->tableOptions);

        $this->addPrimaryKey('pk-xxx', '{{%tablename}}', []);
        $this->addForeignKey(
            'fk-order-customer',
            '{{%order}}', 'customer_id',
            '{{%customer}}', 'id',
            'NO ACTION', 'NO ACTION'
        );

        $this->addColumn('{{%TABLE}}', 'stock_status', $this->boolean()->notNull()->defaultValue(1)->after('status'));
        $this->alterColumn('{{%TABLE}}', 'size', $this->smallInteger(3));



        // 更新已有记录值
        foreach ((new Query)->from('{{%TABLE}}')->each() as $item) {
            $this->update('{{%TABLE}}', ['note' => $item['size']], ['id' => $item['id']]);
        }
        $this->update('{{%TABLE}}', ['size' => 1]);

        $this->batchInsert('{{%lookup}}', $this->lookups[0], $this->lookups[1]);
        */

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        /*
        $this->dropForeignKey('fk-order-customer', '{{%TABLE}}');
        $this->dropTable('{{%TABLE}}');
        $this->dropColumn('{{%TABLE}}', 'stock_status');

        $this->delete('{{%lookup}}', ['type' => ['status']]);
        */
        echo "<?= $className ?> cannot be reverted.\n";

        return false;
    }
}
