<?php

namespace app\modules\transaction\models;

use app\modules\client\models\Client;
use app\modules\deposit\models\Deposit;
use Yii;

/**
 * This is the model class for table "transaction".
 *
 * @property int $id
 * @property int|null $deposit_id
 * @property int|null $client_id
 * @property int|null $type
 * @property float|null $sum
 * @property string|null $created_at
 *
 * @property Client $client
 * @property Deposit $deposit
 */
class Transaction extends \yii\db\ActiveRecord
{
    const DEPOSIT_ACCRUAL = 1;
    const COMMISSION = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction';
    }

    /**
     * {@inheritdoc}
     */
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
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'deposit_id' => 'Deposit ID',
            'client_id' => 'Client ID',
            'type' => 'Type',
            'sum' => 'Sum',
            'created_at' => 'Created At',
        ];
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::class, ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Deposit]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposit()
    {
        return $this->hasOne(Deposit::class, ['id' => 'deposit_id']);
    }
}
