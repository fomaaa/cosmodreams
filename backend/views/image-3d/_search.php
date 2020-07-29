<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Image3d $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="image3d-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php echo $form->field($model, 'id') ?>
    <?php echo $form->field($model, 'asset_bundle') ?>
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
