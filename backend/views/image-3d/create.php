<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Image3d $model
 */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => 'Image3ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="image3d-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
