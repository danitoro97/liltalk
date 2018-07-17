<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'My Yii Application';

?>
<div class="site-index">

    <h1>Web en construccion </h1>
    <?=Html::a('Buscar Salas automaticamente', ['salas/buscar'], ['class' => 'index-sala']) ?>
    <?=Html::a('Buscar Salas manualmente', ['salas/index'], ['class' => 'index-sala']) ?>
</div>
