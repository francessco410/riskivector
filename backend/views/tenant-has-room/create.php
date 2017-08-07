<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TenantHasRoom */

$this->title = 'Create Tenant Has Room';
$this->params['breadcrumbs'][] = ['label' => 'Tenant Has Rooms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-has-room-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
