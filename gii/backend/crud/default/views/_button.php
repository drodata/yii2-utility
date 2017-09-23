<?= "<?php\n" ?>

/* operation button row */

/* @var $this yii\web\View */
<?= "?>\n" ?>

<?= "<?php" ?> if(!empty($this->params['buttons'])): <?= "?>\n" ?>
<div class="row">
    <div class="col-xs-12">
        <div class="button-area" style="padding-bottom:10px;">
            <?= "<?= " ?>implode("\n", $this->params['buttons']) <?= "?>\n" ?>
        </div>
    </div>
</div>
<?= "<?php" ?> endif; <?= "?>\n" ?>
