<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Gallery2 $model
 */

$this->title = 'Обновить: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Гелерея 2', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="gallery2-update">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
