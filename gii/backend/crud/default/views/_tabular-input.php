<?php
/**
 * 修改页面载入已存在的值
 */
?>
<?= "<?php\n" ?>
/* @var $this yii\web\View */
/* @var $form yii\bootatrap\ActiveForm */
/* @var $items  */

use drodata\helpers\Html;
use backend\models\Lookup;
<?= "?>\n" ?>

<?= "<?php" ?> foreach ($items as $token => $item): <?= "?>\n" ?>
<tr class="itemRow" data-key="<?= "<?=" ?> $token <?= "?>" ?>">
    <td><?= "<?=" ?> $token + 1 <?= "?>" ?></td>
    <td>
        <?= "<?=" ?> $form->field($item, "[$token]recipe_id")->label(false)->dropDownList(Lookup::recipes(), [
            'style' => 'min-width:420px',
            'prompt' => '',
        ]) <?= "?>\n" ?>
    </td>
    <td class="text-right">
        <?= "<?=" ?> Html::button('删除', ['class' => 'btn btn-sm btn-danger delete-row']) <?= "?>\n" ?>
    </td>
</tr>
<?= "<?php" ?> endforeach; <?= "?>\n" ?>
