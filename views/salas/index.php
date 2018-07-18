<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\SalasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Salas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="salas-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Crear Sala'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'nombre',
            'descripcion:ntext',
            'categoria.nombre',
            //'numero_participantes',
            //'privada:boolean',
            //'created_at',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{participar}',
                'buttons' => [
                    'participar' => function($url, $model, $key){
                        return Html::a(Yii::t('app', 'Participar'), ['salas/participar', 'sala_id' => $model->id], ['class' => 'btn btn-info']);
                    }
                ]
            ],
        ],
    ]); ?>
</div>
