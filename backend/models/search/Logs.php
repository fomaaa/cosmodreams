<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Logs as LogsModel;

/**
 * Logs represents the model behind the search form about `backend\models\Logs`.
 */
class Logs extends LogsModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['datetime', 'status_code', 'token', 'url', 'response', 'body', 'headers', 'method'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = LogsModel::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'datetime' => $this->datetime,
        ]);

        $query->andFilterWhere(['like', 'status_code', $this->status_code])
            ->andFilterWhere(['like', 'token', $this->token])
            ->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'response', $this->response])
            ->andFilterWhere(['like', 'body', $this->body])
            ->andFilterWhere(['like', 'headers', $this->headers])
            ->andFilterWhere(['like', 'method', $this->method]);

        return $dataProvider;
    }
}
