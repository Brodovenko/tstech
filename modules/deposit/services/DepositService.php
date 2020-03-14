<?php

namespace app\modules\deposit\services;

use app\modules\deposit\models\Deposit;

class DepositService
{
    /**
     * @var Deposit
     */
    private $deposit;

    /**
     * @param Deposit $deposit
     */
    public function setDeposit(Deposit $deposit): void
    {
        $this->deposit = $deposit;
    }

    /**
     * @param $depositId
     * @return Deposit|null
     */
    public function getDeposit($depositId): Deposit
    {
        return Deposit::find()
            ->where(['id' => $depositId])
            ->one();
    }

    /**
     * @param $balance
     */
    public function setBalance($balance): void
    {
        $this->deposit->balance = $balance;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function saveDeposit(): bool
    {
        $currDay = new \DateTime();
        $this->deposit->updated_at = $currDay->format('Y-m-d');

        return $this->deposit->save(false);
    }
}