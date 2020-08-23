<?php

use trntv\filekit\widget\Upload;
use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;
use yii\web\JsExpression;

/**
 * @var yii\web\View $this
 * @var backend\models\Statues $model
 * @var yii\bootstrap4\ActiveForm $form
 */
$model->jpeg_preview = json_decode($model->jpeg_preview);
$model->jpeg = json_decode($model->jpeg);
?>

<div class="statues-form">
    <?php $form = ActiveForm::begin(); ?>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <?php echo $form->errorSummary($model); ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'jpeg')->widget(
                        Upload::class,
                        [
                            'url' => ['/file/storage/upload-with-thumb256'],
                            'maxFileSize' => 5000000, // 5 MiB,
                            'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                        ]);
                    ?>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'author')->dropDownList($author) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'description')->textarea(['rows' => 6]) ?>
                </div>
                <div class="col-md-12">
                    <?php echo $form->field($model, 'description_en')->textarea(['rows' => 6]) ?>
                </div>
                <div class="col-md-6">
                    <?php echo $form->field($model, 'AR')->checkbox() ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <?php echo Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
