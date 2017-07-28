<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Warehouse;
use backend\models\Category;
use backend\models\Condition;
/* @var $this yii\web\View */
/* @var $model backend\models\Product */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'category_id')->dropDownList(    
            ArrayHelper::map(Category::find()->all(),'id','name'),
            ['prompt' => 'Select category']
    )?>
    
    <?= $form->field($model, 'conditions')->dropDownList(    
            ArrayHelper::map(Condition::find()->all(),'id','type'),
            ['prompt' => 'Select condition']
    ) ?>
    
    <?= $form->field($model, 'warehouses')->dropDownList(    
            ArrayHelper::map(Warehouse::find()->all(),'id','address'),
            ['prompt' => 'Select warehouse']
    )?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
