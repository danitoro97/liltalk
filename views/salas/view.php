<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Salas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-9" id="mensajes">
                <?php if ($model->mensajes != null): ?>
                    <?php foreach ($model->mensajes as $mensaje) : ?>
                        <?= $this->render('_mensajes', ['model' => $mensaje]) ?>
                    <?php endforeach ?>
                <?php endif;?>
                
            </div>
        </div>
    </div>

</div>
