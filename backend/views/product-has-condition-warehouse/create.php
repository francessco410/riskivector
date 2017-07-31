<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ProductHasConditionWarehouse */

$this->title = 'Create Product Has Condition Warehouse';
$this->params['breadcrumbs'][] = ['label' => 'Product Has Condition Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-has-condition-warehouse-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
