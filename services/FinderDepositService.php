<?php

namespace app\services;

use app\modules\deposit\models\Deposit;

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
