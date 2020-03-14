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
 * Class FinderDepositService
 * @package app\services
 */
class FinderDepositService implements Finder
{
    /**
     * @return array|\yii\db\ActiveRecord[]
     * @throws \Exception
     */
    public function getDeposits()
    {
        $today = new \DateTime();
        $lastDayOfMonth = ($today->format('Y-m-d') === $today->format('Y-m-t'));

        $dateWhere = ['or'];
        if ($lastDayOfMonth) {
            for ($i = $today->format('d'); $i <= 31; $i++) {
                $dateWhere[] = ["=", "DAY(created_at)", $i];
            }
        } else {
            $dateWhere[] = ["=", "DAY(created_at)", $today->format('d')];
        }

        return Deposit::find()
            ->where($dateWhere)
            ->all();
    }
}
