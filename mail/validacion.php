<?php
use yii\helpers\Url;
?>
<h3>Hola, bienvenido a LilTalk</h3>

<p>
    Haz click en el siguiente enlace para validar su cuenta

<?=Url::to(['usuario/validar', 'token_val' => $token_val], true)?>

Gracias,

LilTalk
</p>
