<?php

namespace app\services;

use app\modules\deposit\models\Deposit;
use app\modules\deposit\services\BalanceChangeStrategy;
use app\modules\deposit\services\DepositService;
use app\modules\transaction\services\TransactionDTO;
use app\modules\transaction\services\TransactionService;
use yii\db\Exception;

/**
 * Class BankService
 * @package app\services
 */
class BankService
{
    /**
     * @var Deposit
     */
    private $deposit;
    /**
     * @var DepositService
     */
    private $depositService;
    /**
     * @var TransactionService
     */
    private $transactionService;
    /**
     * @var BalanceChangeStrategy
     */
    private $strategy;

    /**
     * BankService constructor.
     * @param DepositService $depositService
     * @param TransactionService $transactionService
     */
    public function __construct(
        DepositService $depositService,
        TransactionService $transactionService
    ) {
        $this->depositService = $depositService;
        $this->transactionService = $transactionService;
    }

    /**
     * @param Deposit $deposit
     */
    public function setDeposit(Deposit $deposit):void
    {
        $this->deposit = $deposit;
    }

    /**
     * @param BalanceChangeStrategy $strategy
     */
    public function setBalanceChangeStrategy(BalanceChangeStrategy $strategy):void
    {
        $this->strategy = $strategy;
    }

    /**
     * @return array|bool|\Exception|Exception
     * @throws \Exception
     */
    public function changeDeposit()
    {
        $this->strategy->setDeposit($this->deposit);
        $balanceChange = $this->strategy->getBalanceChange($this->deposit);
        $newBalance = $this->strategy->getNewBalance($this->deposit);

        $today = new \DateTime();

        $transactionDTO = new TransactionDTO();
        $transactionDTO->setClientId($this->deposit->client_id);
        $transactionDTO->setDepositId($this->deposit->id);
        $transactionDTO->setSum($balanceChange);
        $transactionDTO->setType($this->strategy->getType());
        $transactionDTO->setCreatedAt($today->format('Y-m-d'));

        if ($transactionDTO->validate()) {
            $db = \Yii::$app->db;
            $transaction = $db->beginTransaction();
            try {
                $this->transactionService->setTransactionWithDTO($transactionDTO);
                $this->transactionService->saveTransaction();

                $this->depositService->setDeposit($this->deposit);
                $this->depositService->setBalance($newBalance);
                $this->depositService->saveDeposit();
                $transaction->commit();

                return true;
            } catch (Exception $exception) {
                $transaction->rollBack();
                return $exception;
            }
        } else {
            return $transactionDTO->getErrors();
        }
    }
}
