<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ProductHasConditionWarehouse */

$this->title = 'Update Product Has Condition Warehouse: ' . $model->product_id;
$this->params['breadcrumbs'][] = ['label' => 'Product Has Condition Warehouses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->product_id, 'url' => ['view', 'product_id' => $model->product_id, 'condition_id' => $model->condition_id, 'warehouse_id' => $model->warehouse_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="product-has-condition-warehouse-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
