<?php

namespace app\modules\transaction\services;

use app\modules\client\models\Client;
use app\modules\deposit\models\Deposit;
use yii\db\ActiveRecord;

class TransactionDTO extends ActiveRecord
{
    private $deposit_id;
    private $client_id;
    private $sum;
    private $type;
    private $created_at;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    public function rules()
    {
        return [
            [['deposit_id', 'client_id', 'type'], 'integer'],
            [['sum'], 'number'],
            [['created_at'], 'safe'],
            [
                ['client_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Client::class,
                'targetAttribute' => ['client_id' => 'id']
            ],
            [
                ['deposit_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Deposit::class,
                'targetAttribute' => ['deposit_id' => 'id']
            ],
        ];
    }

    /**
     * @return mixed
     */
    public function getDepositId()
    {
        return $this->deposit_id;
    }

    /**
     * @param $depositId
     */
    public function setDepositId($depositId)
    {
        $this->deposit_id = $depositId;
    }

    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param $clientId
     */
    public function setClientId($clientId)
    {
        $this->client_id = $clientId;
    }

    /**
     * @return mixed
     */
    public function getSum()
    {
        return $this->sum;
    }

    /**
     * @param $sum
     */
    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }
}