<?php
$clase = 'mensaje-usuario';

if ($model->usuario_id == Yii::$app->user->identity->id) {
    $clase = 'mensaje-propio';
}
?>
<div class="col-md-12 <?=$clase?>" style="border: 2px solid <?=$model->participante->color?>">
    <p class="">
        <b><?=$model->usuario->nombre?> <?=Yii::$app->formatter->asTime($model->created_at, 'php:H:i')?></b><br><?=$model->mensaje?>
    </p>
</div>
