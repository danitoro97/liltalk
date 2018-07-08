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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'categoria_id' => 'Categoria ID',
            'numero_participantes' => 'Numero Participantes',
        ];
    }

}
