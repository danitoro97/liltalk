<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salas".
 *
 * @property int $id
 * @property string $nombre
 * @property int $creador_id
 * @property string $descripcion
 * @property int $categoria_id
 * @property string $numero_participantes
 * @property bool $privada
 * @property string $created_at
 *
 * @property Mensajes[] $mensajes
 * @property Participantes[] $participantes
 * @property Usuarios[] $usuarios
 * @property Categorias $categoria
 * @property Usuarios $creador
 */
class Salas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'creador_id', 'categoria_id', 'numero_participantes'], 'required'],
            [['creador_id', 'categoria_id'], 'default', 'value' => null],
            [['creador_id', 'categoria_id'], 'integer'],
            [['descripcion'], 'string'],
            [['numero_participantes'], 'number'],
            [['privada'], 'boolean'],
            [['created_at'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['nombre'], 'unique'],
            [['categoria_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categorias::className(), 'targetAttribute' => ['categoria_id' => 'id']],
            [['creador_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['creador_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => Yii::t('app', 'Nombre'),
            'creador_id' => Yii::t('app', 'Administrador'),
            'creador.nombre' => Yii::t('app', 'Administrador'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'categoria_id' => Yii::t('app', 'Tema'),
            'categoria.nombre' => Yii::t('app', 'Tema'),
            'numero_participantes' => Yii::t('app', 'Numero Participantes'),
            'privada' => Yii::t('app', 'Privada'),
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMensajes()
    {
        return $this->hasMany(Mensajes::className(), ['sala_id' => 'id'])->inverseOf('sala');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipantes()
    {
        return $this->hasMany(Participantes::className(), ['sala_id' => 'id'])->inverseOf('sala');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuarios()
    {
        return $this->hasMany(Usuarios::className(), ['id' => 'usuario_id'])->viaTable('participantes', ['sala_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategoria()
    {
        return $this->hasOne(Categorias::className(), ['id' => 'categoria_id'])->inverseOf('salas');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreador()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'creador_id'])->inverseOf('salas');
    }

    /**
     * Cuando creas una sala ,eres el primer participante en ella
     * @param  [type] $insert           [description]
     * @param  [type] $changeAttributes [description]
     * @return [type]                   [description]
     */
    public function afterSave($insert, $changeAttributes)
    {

        if ($insert) {
            $participantes = new Participantes(['sala_id'=> $this->id, 'usuario_id'=>$this->creador_id]);
            $participantes->save();
        }
    }
}
