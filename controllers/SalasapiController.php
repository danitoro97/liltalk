<?php

namespace app\controllers;

use Yii;

use app\models\Usuarios;
use app\models\Participantes;
use app\models\Salas;
use app\models\Mensajes;

use yii\rest\ActiveController;

class SalasapiController extends ActiveController
{
    public $modelClass = 'app\models\Salas';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['index'], $actions['delete'], $actions['update']);
        return $actions;
    }

    public function actionNuevosmensajes($id, $sala_id)
    {

        if (Participantes::find()->where(['usuario_id' =>$_POST['usuario_id']])
        ->andWhere(['sala_id'=> $sala_id])->exists()) {
            return Mensajes::find()
            ->where(['>','id', $id])
            ->andWhere(['sala_id' => $sala_id])
            ->andWhere(['!=','usuario_id', $usuario_id])
            ->all();
        }
    }

    public function actionEnviarmensaje($sala_id)
    {

        if (Participantes::find()->where(['usuario_id' =>$_POST['usuario_id']])
        ->andWhere(['sala_id'=> $sala_id])->exists()) {
            $model = new Mensajes(
                [
                  'usuario_id' => $_POST['usuario_id'],
                  'sala_id' => $sala_id,
                  'mensaje' => $_POST['mensaje'],
                ]
            );
            if ($model->save()) {
                $model->refresh();
                return $model;
            }
        }
    }


    public function actionMensajessalas($sala_id)
    {
        $usuario_id = Usuarios::findOne(['auth_key' => $_POST['auth_key']])->id;
        //$usuario_id = 1;

        if (!Participantes::find()->where(['usuario_id' => $usuario_id])
        ->andWhere(['sala_id'=> $sala_id])->exists()) {
            return false;
        }
        $model = Salas::findOne(['id' => $sala_id]);

        return array_reverse($model->getMensajes()->orderBy('created_at DESC')->limit(20)->all());
    }

    /**
     * Comprueba si el usuario logeado es participante de una sala concreta
     * @param  [type]  $sala_id [description]
     */
    public function isParticipante($sala_id, $usuario_id)
    {
        return Participantes::find()->where(['usuario_id' => $usuario_id])
        ->andWhere(['sala_id'=> $sala_id])->exist();
    }

    /**
     * Devlve las salas en la que participa un usuario
     * @param  [type] $id Identificacion del usuario
     * @return [type]     [description]
     */
    public function actionMissalas($id)
    {
        return Participantes::find()
                    ->where(['usuario_id' => $id])
                    ->all();
    }
}
