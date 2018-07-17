

<?php
use yii\helpers\Html;
$clase = 'mensaje-usuario';

if ($model->usuario_id == Yii::$app->user->identity->id) {
    $clase = 'mensaje-propio';
}
?>
<div class="col-md-12 <?=$clase?>" style="border: 2px solid <?=$model->participante->color?>" data-id="<?=$model->id?>">
    <p class="">
        <b><?=$model->usuario->nombre?> <?=Yii::$app->formatter->asTime($model->created_at, 'php:H:i')?></b><br>
        <?=Html::encode($model->mensaje)?>
    </p>
</div>
