<?php

namespace app\controllers;

use Yii;

use app\models\Usuarios;
use app\models\Participantes;

use yii\rest\ActiveController;

class SalasapiController extends ActiveController
{
    public $modelClass = 'app\models\Salas';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['index'], $action['delete'], $action['update']);
        return $actions;
    }

    /**
     * Devlve las salas en la que participa un usuario
     * @param  [type] $id Identificacion del usuario
     * @return [type]     [description]
     */
    public function actionMissalas($id)
    {
        return Participantes::find()
                    ->where(['usuario_id' => $id)
                    ->all();
    }
}
