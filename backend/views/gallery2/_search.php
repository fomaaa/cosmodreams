<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery2 $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="gallery2-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'jpeg') ?>
    <?php echo $form->field($model, 'name') ?>
    <?php echo $form->field($model, 'author') ?>
    <?php echo $form->field($model, 'description') ?>
    <?php // echo $form->field($model, 'jpeg_hash') ?>
    <?php // echo $form->field($model, 'jpeg_preview') ?>

    <div class="form-group">
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?php echo Html::resetButton('Reset', ['class' => 'btn btn-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
