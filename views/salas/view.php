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
                    $('.derecha').append('<p>Error</p>');
                }

            }
        })
    }
}



setInterval(function()
{
    var id = $('.derecha').find('div').last().attr('data-id');
    if (id == undefined) {
        id = 0;
    }
    $.ajax({
        url:'$nuevosMensajes',
        type:'get',
        data: {
            id: id,
            sala_id: '$model->id'
        },
        success: function(data){
            if (data != '') {
                ponerMensajeNuevo();
                $('.derecha').append(data);
                audio.play();
            }

        }
    })
}, 1000);

$('.absoluto > div a').on('click', function (evt) {
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
var audio = document.getElementById('audio');

function ponerMensajeNuevo()
{
    if ($('#mensaje-nuevo').length == 0) {
        var div = $('<div>');
        div.attr('id', 'mensaje-nuevo');
        div.attr('class', 'mensaje-nuevo');
        var p = $('<p>');

        if (Cookies.get('language') == 'en-US') {
            texto = 'News Messages';
        }
        else {
            texto = 'Nuevos Mensajes';
        }
        p.text(texto);
        div.append(p)
        $('.derecha').append(div);
        div.mouseover(quitarMensajeNuevo);
    }

    $('title').text('Liltalk('+ ($('.derecha > div').length - $('#mensaje-nuevo').index()) + ')')
}

function quitarMensajeNuevo()
{
    $('#mensaje-nuevo').fadeTo( "slow", 0, function(){
        $('#mensaje-nuevo').detach();
    });

    $('title').text('LilTalk');

}

$('.derecha').scroll(function (e) {
    if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            quitarMensajeNuevo();
    }
})

EOT;
$this->registerJs($js);
$this->registerCssFile('@web/css/salas.css');
?>


    <audio controls id="audio">
        <source src="notificacion.ogg" type="audio/ogg">
        <source src="notificacion.mp3" type="audio/mpeg">
        <source src="notificacion.wav" type="audio/wav">
        Your browser does not support the audio element.
    </audio>
    <h1><?= Html::encode($this->title) ?> : <?=Yii::t('app', $model->categoria->nombre)?></h1>
<div class="p">
        <div class="absoluto">
            <div class="numero">
                    <h3><?=$model->getParticipantes()->count()?>/<?=Html::encode($model->numero_participantes)?> participantes</h3>
                     <hr>
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
                    <?php if (isset($model->participantes) && $model->participantes != null): ?>
                        <?php foreach ($model->participantes as $participante) : ?>
                            <?= $this->render('_participante', ['model' => $participante]) ?>
                        <?php endforeach ?>
                    <?php endif;?>
            </div>
        </div>
        <div class="derecha">

                <?php if (isset($model->mensajes) && $model->mensajes != null): ?>

                    <?php foreach (array_reverse($model->getMensajes()->orderBy('created_at DESC')->limit(20)->all()) as $mensaje) : ?>
                        <?= $this->render('_mensajes', ['model' => $mensaje]) ?>
                    <?php endforeach ?>
                <?php endif;?>
        </div>
        <div class="enviar">
            <input type="text" name="mensaje" value="" id="area-mensaje">
            <a href="#" class="btn btn-sm btn-success" id="enviar-mensaje"><span class="glyphicon glyphicon-send"></span></a>
        </div>
</div>
