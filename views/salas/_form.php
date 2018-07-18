<?php

use app\models\Categorias;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Salas */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="salas-form">

    <?php $form = ActiveForm::begin(['id'=> 'salas-form']); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>

    <?php

    $data = Categorias::find()->all();
    $result = [];
    foreach ($data as $tema) {
        $result[$tema->id] = Yii::t('app', $tema->nombre);
    }

    ?>

    <?= $form->field($model, 'categoria_id')->widget(Select2::classname(), [
        'data' => $result,
        'options' => ['placeholder' => Yii::t('app', 'Selecciona una opcion...')],
        'pluginOptions' => [
            'allowClear' => true,
        ],
    ]); ?>

    <?= $form->field($model, 'numero_participantes')->textInput() ?>

    <?= $form->field($model, 'privada')->checkbox() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
