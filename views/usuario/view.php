<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile("@web/css/viewUser.css");
?>
<div class="usuarios-view">
    <div class="titulo">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h2>Biografia</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-offset-1">
                <p><?=Html::encode($model->biografia)?></p>
            </div>
        </div>

    </div>

</div>
