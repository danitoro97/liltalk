<?php


use yii\helpers\Html;

?>
<div class="col-md-12">

    <p>
        <?=Html::encode($model->usuario->nombre) ?>
        <?php if ($model->sala->creador_id == Yii::$app->user->identity->id && $model->usuario_id != Yii::$app->user->identity->id) : ?>
            <a href="#" data-usuario="<?=$model->usuario_id ?>" data-toggle="tooltip" data-placement="right" title="<?=Yii::t('app', 'Expulsa al usuario de la sala')?>">
                <span class="glyphicon glyphicon-remove"></span>
            </a>
        <?php endif?>
    </p>
</div>
