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
            [['nombre', 'descripcion', 'created_at'], 'safe'],
            [['numero_participantes'], 'number'],
            [['privada'], 'boolean'],
        ];
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
        $query = Salas::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

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

        $query->andFilterWhere(['ilike', 'nombre', $this->nombre])
            ->andFilterWhere(['ilike', 'descripcion', $this->descripcion]);

        return $dataProvider;
    }
}
