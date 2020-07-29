<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Image3d $model
 */

$this->title = 'Обновить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Image3ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="image3d-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
