<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 */

$this->title = 'Update Author: ' . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="author-update">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
