

<?php
use yii\helpers\Html;
$clase = 'mensaje-usuario';
if ($model->usuario_id == Yii::$app->user->identity->id) {
    $clase = 'mensaje-propio ';
}
?>

<div class="<?=$clase?> mensaje"  data-id="<?=$model->id?>">
    <p style="border: 2px solid <?=$model->participante->color?>">
        <b><?=$model->usuario->nombre?> <?=Yii::$app->formatter->asTime($model->created_at, 'php:H:i')?></b><br>
        <?=Html::encode($model->mensaje)?>
    </p>
</div>
