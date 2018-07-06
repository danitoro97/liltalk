<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Iniciar sesión');
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/login.css");
?>
<div class="site-login">

    <div class="container">
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',

        ]); ?>

        <div class="row registro">

            <div class="col-md-4">
                <h3><?=Yii::t('app', 'Por qué usar LilTalk?<br><br>LilTalk es un sitio perfecto para conocer gente, conversar sobre intereses comunes y pasar un buen rato chateando con aquellos alrededor del mundo.<br><br>Pruébalo ahora, es gratis!<br>')?></h3>
            </div>
            <div class="col-md-6 col-md-offset-2">
                <div class="col-md-12">
                        <h4><?=Yii::t('app' , 'Puedes disfrutar de la experiencia registrándote ahora') . ' ' . Html::a(Yii::t('app', 'Crear cuenta'), ['usuario/create'], ['class' => 'btn btn-sm btn-info'])?></h4>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                </div>
                <div class="col-md-12">
                    <?= $form->field($model, 'password')->passwordInput() ?>
                </div>
                <div class="row">
                    <div class="col-md-6 col-md-offset-1">
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                    </div>
                    <div class="col-md-3">
                        <?= Html::submitButton(Yii::t('app', 'Iniciar sesión'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>
    </div>

</div>
