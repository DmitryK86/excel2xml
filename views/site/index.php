<?php

/**
 * @var $this yii\web\View
 * @var bool showDownloadBtn
 */

$this->title = 'Excel to Xml';
?>
<div class="site-index">
    <?php
    $form = \yii\widgets\ActiveForm::begin([
    'id' => 'upload-form',
    'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
    ]) ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= \yii\helpers\Html::submitButton('Загрузить', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
    <?php \yii\widgets\ActiveForm::end() ?>
</div>
<form action="<?= \yii\helpers\Url::to(['refresh']);?>">
    <?= \yii\helpers\Html::submitButton('Сбросить', ['class' => 'btn btn-danger']) ?>
</form>
<?php if ($showDownloadBtn):?>
    <form action="<?= \yii\helpers\Url::to(['download']);?>">
        <?= \yii\helpers\Html::submitButton('Скачать XML', ['class' => 'btn btn-info']) ?>
    </form>
<?php endif;?>
</div>
