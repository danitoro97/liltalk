<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "mensajes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $sala_id
 * @property string $mensaje
 *
 * @property Salas $sala
 * @property Usuarios $usuario
 */
class Mensajes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'mensajes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'sala_id', 'mensaje'], 'required'],
            [['usuario_id', 'sala_id'], 'default', 'value' => null],
            [['usuario_id', 'sala_id'], 'integer'],
            [['mensaje'], 'string', 'max' => 255],
            [['sala_id'], 'exist', 'skipOnError' => true, 'targetClass' => Salas::className(), 'targetAttribute' => ['sala_id' => 'id']],
            [['usuario_id'], 'exist', 'skipOnError' => true, 'targetClass' => Usuarios::className(), 'targetAttribute' => ['usuario_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'sala_id' => 'Sala ID',
            'mensaje' => 'Mensaje',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSala()
    {
        return $this->hasOne(Salas::className(), ['id' => 'sala_id'])->inverseOf('mensajes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('mensajes');
    }
}
