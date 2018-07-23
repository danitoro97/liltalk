<?php

/* @var $this yii\web\View */
use yii\helpers\Html;


$this->title = 'My Yii Application';

?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <h2><?=Yii::t('app', 'Mis salas') ?></h2>
            <div class="col-md-11 col-md-offset-1">
                <?php if ($model != null) : ?>
                    <?php foreach ($model as $sala) : ?>
                        <?= $this->render('_salas', ['model' => $sala]) ?>
                    <?php endforeach ?>
                <?php endif;?>
            </div>
        </div>
    </div>
    <h1>Web en construccion </h1>
    <?=Html::a('Buscar Salas automaticamente', ['salas/buscar'], ['class' => 'index-sala']) ?>
    <?=Html::a('Buscar Salas manualmente', ['salas/index'], ['class' => 'index-sala']) ?>
</div>
