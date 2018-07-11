<?php
$clase = 'mensaje-usuario';

if ($model->usuario_id == Yii::$app->user->identity->id) {
    $clase = 'mensaje-propio';
}
?>
<div class="col-md-5 <?=$clase?>" style="border: 2px solid <?=$model->participante->color?>">
    <p class="">
        <?=$model->mensaje?>
    </p>
    <p><?=$model->usuario->nombre?></p>
</div>
