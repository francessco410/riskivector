<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\TenantHasRoom */

$this->title = $model->tenant_id;
$this->params['breadcrumbs'][] = ['label' => 'Tenant Has Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-has-room-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'tenant_id' => $model->tenant_id, 'room_id' => $model->room_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'tenant_id' => $model->tenant_id, 'room_id' => $model->room_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'tenant_id',
            'room_id',
            'accommodation_date',
            'check_out_date',
        ],
    ]) ?>

</div>
