<?php

use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\web\JsExpression;
use trntv\filekit\widget\Upload;

/**
 * @var yii\web\View $this
 * @var backend\models\Statues $model
 * @var yii\bootstrap4\ActiveForm $form
 */
$model->jpeg_preview = json_decode($model->jpeg_preview);
$model->asset_bundle = json_decode($model->asset_bundle);
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
                        <?php echo $form->field($model, 'asset_bundle')->widget(
                            Upload::class,
                            [
                                'url' => ['/file/storage/upload-assets'],
                                'maxFileSize' => 5000000, // 5 MiB,
//                                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                            ]);
                        ?>
                    </div>
                    <div class="col-md-6">
                        <?php echo $form->field($model, 'jpeg_preview')->widget(
                            Upload::class,
                            [
                                'url' => ['/file/storage/upload'],
                                'maxFileSize' => 5000000, // 5 MiB,
                                'acceptFileTypes' => new JsExpression('/(\.|\/)(gif|jpe?g|png)$/i'),
                            ]);
                        ?>
                    </div>
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

                </div>
            </div>
            <div class="card-footer">
                <?php echo Html::submitButton('Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
        </div>
    <?php ActiveForm::end(); ?>
</div>
