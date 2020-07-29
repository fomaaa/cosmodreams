<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Author $model
 */

$this->title = 'Create Author';
$this->params['breadcrumbs'][] = ['label' => 'Authors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="author-create">

    <?php echo $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
