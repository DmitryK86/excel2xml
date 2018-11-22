<?php

/* @var $this yii\web\View */

$this->title = 'Excel to Xml';
?>
<div class="site-index">
    <?php
    $form = \yii\widgets\ActiveForm::begin([
    'id' => 'login-form',
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
