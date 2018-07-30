<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'My Yii Application';

?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <h2><?=Yii::t('app', 'Mis salas') ?></h2>

                <?php if ($model != null) : ?>
                    <?php foreach ($model as $sala) : ?>
                        <?= $this->render('_salas', ['model' => $sala]) ?>
                    <?php endforeach ?>
                <?php endif;?>
        </div>
        <div class="row">
            <h2><?=Yii::t('app', 'Ultimas salas') ?></h2>
                <?php if ($salas != null) : ?>
                    <?php foreach ($salas as $sala) : ?>
                        <?= $this->render('_salasDisponibles', ['model' => $sala->salas]) ?>
                    <?php endforeach ?>
                <?php endif;?>
        </div>
    </div>
    <h1>Web en construccion </h1>
    <?=Html::a('Buscar Salas automaticamente', ['salas/buscar'], ['class' => 'index-salas']) ?>
    <?=Html::a('Buscar Salas manualmente', ['salas/index'], ['class' => 'index-salas']) ?>
</div>
