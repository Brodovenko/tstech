<?php

namespace app\services;

use app\modules\deposit\models\Deposit;
use app\modules\deposit\services\BalanceChangeStrategy;
use app\modules\deposit\services\DepositService;
use app\modules\transaction\services\TransactionDTO;
use app\modules\transaction\services\TransactionService;
use app\modules\transaction\models\Transaction;
use yii\db\Exception;
use yii\db\Expression;

/**
 * Class FinderCommissionService
 * @package app\services
 */
class FinderCommissionService implements Finder
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getDeposits()
    {
        return Deposit::find()
            ->where(["=", "DAY(created_at)", 1])
            ->all();
    }
}
