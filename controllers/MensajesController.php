<?php

namespace app\controllers;

use Yii;

use app\models\Mensajes;

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
                'only' => ['crear'],
                'rules' =>
                [
                    [
                        'actions' => ['crear'],
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
}
