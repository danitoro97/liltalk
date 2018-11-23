<?php

namespace app\models;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\IdentityInterface;
use Spatie\Dropbox\Exceptions\BadRequest;
use yii\imagine\Image;
use Imagine\Image\Box;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string $nombre
 * @property string $password
 * @property string $email
 * @property string $auth_key
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
    * Variable para comprobar que introduce la misma contraseña dos veces.
    * @var [type]
    */
    public $password_repeat;

    /**
     * Constante para el escenario crear.
     * @var string
     */
    public const ESCENARIO_CREAR = 'crear';
    /**
     * Constante para el escenario actualizar.
     * @var string
     */
    public const ESCENARIO_ACTUALIZAR = 'actualizar';

    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * [fields description]
     * @return [type] [description]
     */
    public function fields()
    {
        return [
            'id',
            'nombre',
            'email',
            'url',
            'token_val',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email','biografia','zona_horaria'], 'required'],
            [['password_repeat', 'password'], 'required', 'on' => self::ESCENARIO_CREAR],
             [['password_repeat'], 'compare', 'compareAttribute' => 'password', 'on' => [self::ESCENARIO_CREAR, self::ESCENARIO_ACTUALIZAR]],
            [['nombre', 'password', 'email', 'auth_key'], 'string', 'max' => 255],
            [['biografia','url'],'safe'],
            [['auth_key'], 'unique'],
            [['email'],'email'],
            [['email'], 'unique'],
            [['nombre'], 'unique'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'nombre' => Yii::t('app', 'Nombre'),
            'password' => Yii::t('app', 'Contraseña'),
            'email' => Yii::t('app', 'Correo electronico'),
            'password_repeat' => Yii::t('app', 'Repetir contraseña'),
            'biografia' => Yii::t('app', 'Biografia'),
            'zona_horaria' => Yii::t('app', 'Zona Horaria'),
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @param null|mixed $type
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
    /**
     * Validates password.
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $key = Yii::$app->security->generateRandomString();
                while (self::findOne(['auth_key' => $key]) != null) {
                    $key = Yii::$app->security->generateRandomString();
                }
                $this->auth_key = $key;
                $key = Yii::$app->security->generateRandomString();
                while (self::findOne(['token_val' => $key]) != null) {
                    $key = Yii::$app->security->generateRandomString();
                }
                $this->token_val = $key;
                if ($this->scenario == self::ESCENARIO_CREAR) {
                    $this->password = Yii::$app->security->generatePasswordHash($this->password);
                }
            } else {
                //Actualizar
                if ($this->scenario == self::ESCENARIO_ACTUALIZAR) {
                    if ($this->nombre == '') {
                        $this->nombre = $this->getOldAttribute('nombre');
                    }
                    if ($this->email == '') {
                        $this->email = $this->getOldAttribute('email');
                    }
                    if ($this->email != $this->getOldAttribute('email')) {
                        $key = Yii::$app->security->generateRandomString();
                        while (self::findOne(['token_val' => $key]) != null) {
                            $key = Yii::$app->security->generateRandomString();
                        }
                        $this->token_val = $key;
                        //mandar correo
                        Yii::$app->user->logout();
                        if ($this->enviarCorreo()) {
                            Yii::$app->session->setFlash('info', Yii::t('app', 'Se ha enviado un correo de verificacion , por favor revise su cuenta de correo'));
                        } else {
                            Yii::$app->session->setFlash('danger', Yii::t('app', 'Error with email'));
                        }
                    }
                    if ($this->password == '') {
                        $this->password = $this->getOldAttribute('password');
                    } else {
                        $this->password = Yii::$app->security->generatePasswordHash($this->password);
                    }
                }
            }
            return true;
        }
        return false;
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getParticipantes()
    {
        return $this->hasMany(Participantes::className(), ['usuario_id' => 'id'])->inverseOf('usuario');
    }

    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSalas()
    {
        return $this->hasMany(Salas::className(), ['id' => 'sala_id'])->viaTable('participantes', ['usuario_id' => 'id'])->inverseOf('creador');
    }
    /**
    * @return \yii\db\ActiveQuery
    */
    public function getSalas0()
    {
        return $this->hasMany(Salas::className(), ['creador_id' => 'id']);
    }

    /**
     * Envia un correo para la validacion de la cuenta
     * @return [type] [description]
     */
    public function enviarCorreo()
    {
        $enlace = Url::to(['usuario/validar', 'token_val' => $this->token_val], true);
        return Yii::$app->mailer->compose('validacion', ['token_val' => $this->token_val])
              ->setFrom(Yii::$app->params['adminEmail'])
              ->setTo($this->email)
              ->setSubject('Correo de confirmacion de LilTalk')
              ->setTextBody('Hola, bienvenido a LilTalk ' . $enlace . ' Gracias,LilTalk')
              ->send();
    }

    public function upload()
    {

        $id = $this->id;
        $filepath = 'uploads/' . $id . '.' . $this->imageFile->extension;

        $this->imageFile->saveAs($filepath);
        Image::thumbnail($filepath, 30, 30)
                ->resize(new Box(30, 30))
                ->save($filepath,['quality' => 100]);

        $client = new \Spatie\Dropbox\Client(getenv('DROPBOX'));

        try {
            $client->delete($filepath);
        } catch (BadRequest $e) {
            // No se hace nada
        }
        $client->upload($filepath, file_get_contents($filepath, 'overwrite'));
        $res = $client->createSharedLinkWithSettings($filepath, [
            'requested_visibility' => 'public',
        ]);
        $res['url'][mb_strlen($res['url']) - 1] = '1';
        $this->url = $res['url'];

        return $res['url'];
    }

    public function getIcono()
    {
        $ruta = 'icon.png';
        if ($this->url !== null) {
            $ruta = $this->url;
        }
        return Html::img($ruta, ['class' => 'img-responsive img-circle']);
    }
}
