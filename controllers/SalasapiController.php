<?php

namespace app\controllers;

use Yii;

use app\models\Usuarios;
use app\models\Participantes;
use app\models\Salas;
use app\models\Mensajes;
use app\models\SalasDisponibles;

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

    /**
     * Te unes a una sala
     * @param  [type] $sala_id [description]
     * @return [type]          [description]
     */
    public function actionParticipar($sala_id)
    {
        $usuario_id = $this->findUsuario('bb')->id;
        $participantes = new Participantes(['usuario_id' => $usuario_id, 'sala_id'=> $sala_id]);

        if ($this->isParticipante($sala_id, $usuario_id) || $participantes->save()) {
            return Salas::findOne($sala_id);
        }
        return false;
    }

    /**
     * Devuelvo los ultimos mensajes de la sala
     * @param  [type] $id      Ultimo meensaje que tiene el usuario
     * @param  [type] $sala_id Sala
     * @return [type]          Mensajes
     */
    public function actionNuevosmensajes($id, $sala_id)
    {
        $usuario_id = $this->findUsuario($_POST['auth_key'])->id;
        if ($this->isParticipante($sala_id, $usuario_id)) {
            return Mensajes::find()
            ->where(['>','id', $id])
            ->andWhere(['sala_id' => $sala_id])
            ->andWhere(['!=','usuario_id', $usuario_id])
            ->all();
        }
    }

    /**
     * Devuelvo el usuario por su auth_key
     * @param  [type] $auth_key [description]
     * @return [type]           [description]
     */
    public function findUsuario($auth_key)
    {
        return Usuarios::findOne(['auth_key' => $auth_key]);
    }

    /**
     * Devuelvo todas las salas disponibles
     * @return [type] [description]
     */
    public function actionSalasdisponibles()
    {
        return SalasDisponibles::find()->all();
    }

    /**
     * Añado un mensaje a la db
     * @param  [type] $sala_id Identificador de la Sala
     * @return [type]          Mensaje
     */
    public function actionEnviarmensaje($sala_id)
    {
        $usuario_id = $this->findUsuario($_POST['auth_key'])->id;
        if ($this->isParticipante($sala_id, $usuario_id)) {
            $model = new Mensajes(
                [
                  'usuario_id' => $usuario_id,
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

    /**
     * Devuelvo los ultimos mensajes de la sala
     * @param  [type] $sala_id Identificador de la sala
     * @return [type]          [description]
     */
    public function actionMensajessalas($sala_id)
    {
        $usuario_id = $this->findUsuario($_POST['auth_key'])->id;
        //$usuario_id = 1;

        if (!$this->isParticipante($sala_id, $usuario_id)) {
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
        ->andWhere(['sala_id'=> $sala_id])->exists();
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
