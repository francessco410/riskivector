<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Tariff */

$this->title = 'Update Tariff: ' . $model->flat_id;
$this->params['breadcrumbs'][] = ['label' => 'Tariffs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->flat_id, 'url' => ['view', 'id' => $model->flat_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tariff-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
