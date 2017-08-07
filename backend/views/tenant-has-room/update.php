<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\TenantHasRoom */

$this->title = 'Update Tenant Has Room: ' . $model->tenant_id;
$this->params['breadcrumbs'][] = ['label' => 'Tenant Has Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tenant_id, 'url' => ['view', 'tenant_id' => $model->tenant_id, 'room_id' => $model->room_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tenant-has-room-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
