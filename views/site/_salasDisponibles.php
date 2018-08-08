<?php

use yii\helpers\Html;

 ?>

 <div class="col-md-3 index-salas">
      <?= Html::a(Html::encode($model->nombre), ['salas/participar', 'sala_id' => $model->id]); ?>
 </div>
