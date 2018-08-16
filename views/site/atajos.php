<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = Yii::t('app','Clave acceso');
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?=Yii::t('app', 'Cada clave acceso depende del navegador y del sistema operativo')?></h2>
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-1 table-responsive">
            <table class="table table-striped">
                <tr>
                    <th><?=Yii::t('app', 'Navegador')?></th>
                    <th>Windows</th>
                    <th>Linux</th>
                    <th>Mac</th>
                </tr>
                <tr>
                    <td>Internet Explorer</td>
                    <td>[Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>N/A</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Chrome</td>
                    <td>[Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>[Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>[Control] [Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                </tr>
                <tr>
                    <td>Firefox</td>
                    <td>[Alt] [Shift] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>[Alt] [Shift] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>[Control] [Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                </tr>
                <tr>
                    <td>Safari</td>
                    <td>[Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                    <td>N/A</td>
                    <td>[Control] [Alt] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                </tr>
                <tr>
                    <td>Opera</td>
                    <td colspan="3">Opera 15 or newer: [Alt] + <em><?=Yii::t('app','Clave acceso')?><br></em>Opera 12.1 or older: [Shift] [Esc] + <em><?=Yii::t('app','Clave acceso')?></em></td>
                </tr>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-8 col-md-offset-1">
            <table class="table table-striped">
                <tr>
                    <th><?=Yii::t('app', 'Clave acceso')?></th>
                    <th><?=Yii::t('app','Accion')?></th>
                </tr>
                <tr>
                    <td>h</td>
                    <td><?=Yii::t('app','Ir a inicio')?></td>
                </tr>
                <tr>
                    <td>a</td>
                    <td><?=Yii::t('app', 'Busquedad automática de sala')?></td>
                </tr>
                <tr>
                    <td>l</td>
                    <td><?=Yii::t('app', 'Listado de salas disponibles')?></td>
                </tr>
                <tr>
                    <td>c</td>
                    <td><?=Yii::t('app', 'Crear una sala')?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
