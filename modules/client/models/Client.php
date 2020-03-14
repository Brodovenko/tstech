<?php

namespace app\modules\client\models;

use app\modules\deposit\models\Deposit;
use app\modules\transaction\models\Transaction;
use Yii;

/**
 * This is the model class for table "client".
 *
 * @property int $id
 * @property string $name
 * @property string $second_name
 * @property int|null $gender
 * @property string|null $birthday
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Deposit[] $deposits
 * @property Transaction[] $transactions
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'client';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'second_name'], 'required'],
            [['gender'], 'integer'],
            [['birthday', 'created_at', 'updated_at'], 'safe'],
            [['name', 'second_name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'second_name' => 'Second Name',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Deposits]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDeposits()
    {
        return $this->hasMany(Deposit::class, ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Transactions]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['client_id' => 'id']);
    }
}
