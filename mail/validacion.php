<?php
use yii\helpers\Url;
?>
<h3><?=Yii::t('app', 'Hola, bienvenido a') .' ' .  Yii::$app->name ?></h3>

<p>
    <?=Yii::t('app', 'Haz click en el siguiente enlace para validar su cuenta')?>

    <?=Url::to(['usuario/validar', 'token_val' => $token_val], true)?>

    <?=Yii::t('app', 'Gracias')?>

    <?= Yii::$app->name?>
</p>
