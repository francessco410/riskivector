<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TenantHasRoomSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tenant Has Rooms';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tenant-has-room-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Tenant Has Room', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tenant_id',
            'room_id',
            'accommodation_date',
            'check_out_date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
