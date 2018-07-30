<?php

use yii\helpers\Url;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Salas */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Salas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$ruta = Url::to(['mensajes/crear']);
$nuevosMensajes = Url::to(['mensajes/view']);
$expulsar = Url::to(['salas/expulsar']);

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
                if (data) {
                    input.val(null);
                } else {
                    $('#mensajes').append('<p>Error</p>');
                }

            }
        })
    }
}



setInterval(function()
{
    var id = $('#mensajes').find('div').last().attr('data-id');
    if (id == undefined) {
        id = 0;
    }
    $.ajax({
        url:'$nuevosMensajes',
        type:'get',
        data: {
            id: $('#mensajes').find('div').last().attr('data-id'),
            sala_id: '$model->id'
        },
        success: function(data){
            $('#mensajes').append(data);
        }
    })
}, 1000);

$('.participante > div a').on('click', function (evt) {
    evt.preventDefault();
    var usuario = $(this).attr('data-usuario');
    var padre = $(this).parent();
    $.ajax({
        url: '$expulsar',
        type:'post',
        data: {
            usuario_id: usuario,
            sala_id : '$model->id'
        },
        success: function (data) {
            if (data) {
                padre.remove();
            }
        }
    })
});

EOT;
$this->registerJs($js);
$this->registerCssFile('@web/css/salas.css');
?>
<div class="salas-view">

    <h1><?= Html::encode($this->title) ?> : <?=Yii::t('app', $model->categoria->nombre)?></h1>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1 chat">
                <div class="col-md-2 participante">
                    <div class="numero">
                        <h3><?=$model->getParticipantes()->count()?>/<?=Html::encode($model->numero_participantes)?></h3>
                        <?php if ($model->creador_id == Yii::$app->user->identity->id) :?>
                                <?=Html::a(Yii::t('app', 'Eliminar sala'), ['salas/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                       'confirm' => Yii::t('app', '¿Estas seguro que deseas eliminar esta sala ?'),
                                       'method' => 'post',
                                   ]
                                ])?>
                        <?php else : ?>
                                <?=Html::a(Yii::t('app', 'Abandonar sala'), ['salas/abandonar', 'sala_id' => $model->id], [
                                    'class' => 'btn btn-sm btn-danger',
                                    'data' => [
                                       'confirm' => Yii::t('app', '¿Estas seguro que deseas abandonar esta sala ?'),
                                       'method' => 'post',
                                   ]
                                ])?>
                        <?php endif;?>
                    </div>

                    <?php if (isset($model->participantes) && $model->participantes != null): ?>
                        <?php foreach ($model->participantes as $participante) : ?>
                            <?= $this->render('_participante', ['model' => $participante]) ?>
                        <?php endforeach ?>
                    <?php endif;?>
                </div>
                <div class="col-md-10" id="mensajes">
                    <?php if (isset($model->mensajes) && $model->mensajes != null): ?>
                        <?php foreach ($model->getMensajes()->orderBy('created_at ASC')->limit(20)->all() as $mensaje) : ?>
                            <?= $this->render('_mensajes', ['model' => $mensaje]) ?>
                        <?php endforeach ?>
                    <?php endif;?>

                </div>
                <div class="col-md-10 col-md-offset-2">
                    <input type="text" name="mensaje" value="" id="area-mensaje">
                    <a href="#" class="btn btn-sm btn-success" id="enviar-mensaje">Enviar</a>
                </div>
            </div>

        </div>
    </div>

</div>
