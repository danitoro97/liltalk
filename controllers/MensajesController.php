<?php

namespace app\controllers;

use Yii;

use app\models\Mensajes;
use app\models\Participantes;

use yii\filters\AccessControl;

class MensajesController extends \yii\web\Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['crear','view'],
                'rules' =>
                [
                    [
                        'actions' => ['crear','view'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                ],
            ]
        ];
    }

    /**
     * crear un mensaje
     * @return [type] [description]
     */
    public function actionCrear()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $model = new Mensajes(
                [
                    'usuario_id' => Yii::$app->user->identity->id,
                    'sala_id' => Yii::$app->request->post('sala_id'),
                    'mensaje' => Yii::$app->request->post('mensaje'),

                ]
            );
            if ($model->save()) {
                $model->refresh();
                return $this->renderPartial('/salas/_mensajes', ['model' => $model]);
            } else {
                return '<p>Error</p>';
            }
        }
    }

    /**
     * Envia los nuevos mensajes de la sala
     * @param  [type] $id      [description]
     * @param  [type] $sala_id [description]
     * @return [type]          [description]
     */
    public function actionView($id, $sala_id)
    {
        if ($this->isParticipante($sala_id)) {
            $mensajes = Mensajes::find()
            ->where(['>','id', $id])
            ->andWhere(['sala_id' => $sala_id])
            ->all();
            $html = '';
            foreach ($mensajes as $mensaje) {
                $html .= $this->renderPartial('/salas/_mensajes', ['model' => $mensaje]);
            }
            return $html;
        }
    }

    /**
     * Comprueba si el usuario logeado es participante de una sala concreta
     * @param  [type]  $sala_id [description]
     */
    public function isParticipante($sala_id)
    {
        return Participantes::find()->where(['usuario_id' => Yii::$app->user->identity->id])
        ->andWhere(['sala_id'=> $sala_id])->all() != null;
    }
}
