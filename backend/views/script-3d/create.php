<?php

/**
 * @var yii\web\View $this
 * @var backend\models\Script3d $model
 */

$this->title = 'Создать';
$this->params['breadcrumbs'][] = ['label' => '3D сценарии', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="script3d-create">

    <?php echo $this->render('_form', [
        'model' => $model,
        'author' => $author
    ]) ?>

</div>
