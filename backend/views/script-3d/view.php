<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var backend\models\Script3d $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Script3ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="script3d-view">
    <div class="card">
        <div class="card-header">
            <?php echo Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php echo Html::a('Delete', ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'post',
                ],
            ]) ?>
        </div>
        <div class="card-body">
            <?php echo DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    'asset_bundle',
                    'name',
                    'author',
                    'description:ntext',
                    'jpeg_hash:ntext',
                    'jpeg_preview:ntext',
                    
                ],
            ]) ?>
        </div>
    </div>
</div>
