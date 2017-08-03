<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\TenantFine */

$this->title = 'Create Tenant Fine';
$this->params['breadcrumbs'][] = ['label' => 'Tenant Fines', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-fine-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
