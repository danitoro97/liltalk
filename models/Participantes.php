<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "participantes".
 *
 * @property int $id
 * @property int $usuario_id
 * @property int $sala_id
 *
 * @property Salas $sala
 * @property Usuarios $usuario
 */
class Participantes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'participantes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario_id', 'sala_id'], 'required'],
            [['usuario_id', 'sala_id'], 'default', 'value' => null],
            [['usuario_id', 'sala_id'], 'integer'],
            [['usuario_id', 'sala_id'], 'unique', 'targetAttribute' => ['usuario_id', 'sala_id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSala()
    {
        return $this->hasOne(Salas::className(), ['id' => 'sala_id'])->inverseOf('participantes');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuarios::className(), ['id' => 'usuario_id'])->inverseOf('participantes');
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
            return true;
        }
        return false;
    }
}
