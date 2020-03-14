<?php

namespace app\modules\deposit\services;

use app\modules\deposit\models\Deposit;

/**
 * Interface BalanceChangeStrategy
 * @package app\modules\deposit\services
 */
interface BalanceChangeStrategy
{
    /**
     * @param Deposit $deposit
     * @return mixed
     */
    public function setDeposit(Deposit $deposit);

    /**
     * @return mixed
     */
    public function getType();

    /**
     * @return mixed
     */
    public function getBalanceChange();

    /**
     * @return mixed
     */
    public function getNewBalance();
}