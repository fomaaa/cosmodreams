<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;

/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 * @var yii\bootstrap4\ActiveForm $form
 */
?>

<div class="author-form">
    <?php $form = ActiveForm::begin(); ?>
        <div class="card">
            <div class="card-body">
                <?php echo $form->errorSummary($model); ?>

                <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
                <?php echo $form->field($model, 'description_en')->textInput(['maxlength' => true]) ?>

            </div>
            <div class="card-footer">
                <?php echo Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
