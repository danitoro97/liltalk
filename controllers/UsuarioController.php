<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;

/**
 * UsuarioController implements the CRUD actions for Usuarios model.
 */
class UsuarioController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete','update','create','validar'],
                'rules' =>
                [
                    [
                        'actions' => ['delete','update'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'actions' => ['create','validar'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                ],
            ]
        ];
    }

    /**
     * Displays a single Usuarios model.
     * @param [type] $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->layout = 'login';
        $model = new Usuarios();
        $model->scenario = Usuarios::ESCENARIO_CREAR;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if (!$model->enviarCorreo()) {
                Yii::$app->session->setFlash('info', Yii::t('app', 'No se ha podido enviar el correo de verificacion'));
                $model->password = '';
                $model->password_repeat = '';
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            Yii::$app->session->setFlash('info', Yii::t('app', 'Se ha enviado un correo de verificacion , por favor revise su cuenta de correo'));
            return $this->goHome();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Valida un usuario
     * @param  [type] $token_val Token identificativo
     * @return [type]            [description]
     */
    public function actionValidar($token_val)
    {

        if ($check = Usuarios::findOne(['token_val' => $token_val])) {
            $check->token_val = null;
            $check->save();
            Yii::$app->user->login($check);
            Yii::$app->session->setFlash('success', Yii::t('app', 'Usuario validado con exito'));
        }
        return $this->goHome();
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $model = Yii::$app->user->identity;
        $model->password = '';
        $model->scenario = Usuarios::ESCENARIO_ACTUALIZAR;
        if ($model->load(Yii::$app->request->post())) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->imageFile != null) {
                 $model->upload();
            }
            $model->imageFile = null;

            $model->save();
            return $this->goHome();
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        Yii::$app->user->identity->delete();

        return $this->redirect(['index']);
    }

    /**
     * [findModel description]
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    protected function findModel($id)
    {
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
