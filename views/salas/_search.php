<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\SalasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="salas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'creador_id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'categoria_id') ?>

    <?php // echo $form->field($model, 'numero_participantes') ?>

    <?php // echo $form->field($model, 'privada')->checkbox() ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
