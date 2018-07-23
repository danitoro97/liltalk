<?php

use yii\helpers\Html;

 ?>

 <div class="col-md-3 index-salas">
     <?=Html::a(Html::encode($model->sala->nombre), ['salas/view', 'id' => $model->sala_id]) ?>
 </div>
