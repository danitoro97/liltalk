<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Salas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$ruta = Url::to(['mensajes/crear']);
$js = <<<EOT
$('#enviar-mensaje').on('click', mensajes);
$('#area-mensaje').on('keypress', function(evt) {
    var x = evt.which || evt.keyCode;
    if (x == '13' ) {
        mensajes(evt);
    }
})
function mensajes (evt) {
    evt.preventDefault();
    var input = $('#area-mensaje')
    var mensaje = input.val();
    if (mensaje != '') {
        $.ajax({
            url:'$ruta',
            type:'post',
            data: {
                mensaje: mensaje,
                sala_id : '$model->id'
            },
            success : function (data) {
                $('#mensajes').append(data);
                input.val(null);
            }
        })
    }
}

EOT;
$this->registerJs($js);
$this->registerCssFile('@web/css/salas.css');
?>
<div class="salas-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-1" id="mensajes">
                <?php if (isset($model->mensajes) && $model->mensajes != null): ?>
                    <?php foreach ($model->getMensajes()->orderBy('created_at ASC')->limit(20)->all() as $mensaje) : ?>
                        <?= $this->render('_mensajes', ['model' => $mensaje]) ?>
                    <?php endforeach ?>
                <?php endif;?>

            </div>
            <div class="col-md-8 col-md-offset-1 boton">
                <input type="text" name="mensaje" value="" id="area-mensaje">
                <a href="#" class="btn btn-sm btn-success" id="enviar-mensaje">Enviar</a>
            </div>
        </div>
    </div>

</div>
