<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Salas;

/**
 * SalasSearch represents the model behind the search form of `app\models\Salas`.
 */
class SalasSearch extends Salas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'creador_id', 'categoria_id'], 'integer'],
            [['nombre', 'descripcion', 'created_at','creador.nombre','categoria.nombre'], 'safe'],
            [['numero_participantes'], 'number'],
            [['privada'], 'boolean'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), [
            'categoria.nombre',
            'creador.nombre'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SalasDisponibles::find()
        ->joinWith(['salas'])
        ->joinWith(['categoria']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['categoria.nombre'] = [
            'asc' => ['categorias.nombre' => SORT_ASC],
            'desc' => ['categorias.nombre' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'creador_id' => $this->creador_id,
            'categoria_id' => $this->categoria_id,
            'numero_participantes' => $this->numero_participantes,
            'privada' => $this->privada,
            'created_at' => $this->created_at,
        ]);

        $query->andFilterWhere(['ilike', 'salas.nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'categorias.nombre', $this->getAttribute('categoria.nombre')])
            //->andFilterWhere(['ilike', 'usuarios.nombre', $this->getAttribute('creador.nombre')])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
