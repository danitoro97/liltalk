<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "salas_disponibles".
 *
 * @property int $sala_id
 * @property string $nombre
 * @property string $descripcion
 * @property int $categoria_id
 * @property string $numero_participantes
 */
class SalasDisponibles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'salas_disponibles';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['sala_id', 'categoria_id'], 'default', 'value' => null],
            [['sala_id', 'categoria_id'], 'integer'],
            [['descripcion'], 'string'],
            [['numero_participantes'], 'number'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'sala_id' => 'Sala ID',
            'nombre' => Yii::t('app', 'Nombre de la Sala'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'categoria_id' => 'Categoria ID',
            'numero_participantes' => 'Numero Participantes',
        ];
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
    public function getSalas()
    {
        return $this->hasOne(Salas::className(), ['id' => 'sala_id']);
    }
}
