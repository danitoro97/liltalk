<?php

namespace app\controllers;

use Yii;

use app\models\Usuarios;

use yii\rest\ActiveController;

class UsersController extends ActiveController
{
    public $modelClass = 'app\models\Usuarios';

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['view'], $actions['index'], $action['delete'], $action['update']);
        return $actions;
    }

    /**
     * Comprueba credenciales del usuario y devuelve sus datos si existe o falso si no existe
     * @return [type] [description]
     */
    public function actionLogin()
    {
        if (!empty($_POST)) {
            $nombre = $_POST['usuario'];
            $password = $_POST['password'];

            $usuario = Usuarios::findOne(['nombre' => $nombre]);
            if ($usuario != null) {
                return (Yii::$app->getSecurity()->validatePassword($password, $usuario->password)) ? $usuario: false;
            }
        }
    }
}
