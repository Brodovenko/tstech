<?php

namespace app\modules\deposit\services;

use app\modules\deposit\models\Deposit;
use app\modules\transaction\models\Transaction;

/**
 * Class DepositAccrual
 * @package app\modules\deposit\services
 */
class DepositAccrual implements BalanceChangeStrategy
{
    /**
     * @var Deposit
     */
    private $deposit;

    /**
     * @param Deposit $deposit
     */
    public function setDeposit(Deposit $deposit):void
    {
        $this->deposit = $deposit;
    }

    /**
     * @return int|mixed
     */
    public function getType()
    {
        return Transaction::DEPOSIT_ACCRUAL;
    }

    /**
     * @return float|mixed
     */
    public function getBalanceChange()
    {
        return round($this->deposit->balance * $this->deposit->percent / 100, 2);
    }

    /**
     * @return float|mixed|null
     */
    public function getNewBalance()
    {
        return $this->deposit->balance + $this->getBalanceChange();
    }
}