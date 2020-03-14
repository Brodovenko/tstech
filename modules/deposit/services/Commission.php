<?php

namespace app\modules\deposit\services;

use app\modules\deposit\models\Deposit;
use app\modules\transaction\models\Transaction;

/**
 * Class Commission
 * @package app\modules\deposit\services
 */
class Commission implements BalanceChangeStrategy
{
    /**
     * @var Deposit
     */
    private $deposit;

    /**
     * @param Deposit $deposit
     * @return mixed|void
     */
    public function setDeposit(Deposit $deposit): void
    {
        $this->deposit = $deposit;
    }

    /**
     * @return int|mixed
     */
    public function getType()
    {
        return Transaction::COMMISSION;
    }

    /**
     * @return float|int|mixed
     * @throws \Exception
     */
    public function getBalanceChange()
    {
        $commission = 0;
        $balance = $this->deposit->balance;
        if ($this->between($balance, 0, 1000)) {
            $percentBalance = $balance * 0.05;
            $commission = $percentBalance < 50 ? 50 : $percentBalance;
        } elseif ($this->between($balance, 1000, 10000)) {
            $commission = $balance * 0.06;
        } elseif ($balance > 10000) {
            $percentBalance = $balance * 0.07;
            $commission = $percentBalance > 5000 ? 5000 : $percentBalance;
        }

        return $this->isOlderThanMonth() ? $this->calculateCommissionForNewBalance($commission) : $commission;
    }

    /**
     * @return float|int|mixed|null
     * @throws \Exception
     */
    public function getNewBalance()
    {
        return $this->deposit->balance - $this->getBalanceChange();
    }

    /**
     * @param $balance
     * @param $from
     * @param $to
     * @return bool
     */
    private function between($balance, $from, $to)
    {
        if ($balance >= $from && $balance <= $to) {
            return true;
        }

        return false;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    private function isOlderThanMonth()
    {
        $createdAt = new \DateTime($this->deposit->created_at);
        $prevMonth = new \DateTime('-1 month');

        return $createdAt->format('Y-m') === $prevMonth->format('Y-m');
    }

    /**
     * @param float $commission
     * @return float
     * @throws \Exception
     */
    private function calculateCommissionForNewBalance(float $commission)
    {
        $createdAt = new \DateTime($this->deposit->created_at);

        return round($commission / $createdAt->format('j'), 2);
    }
}