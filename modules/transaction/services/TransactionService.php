<?php

namespace app\modules\transaction\services;

use app\modules\transaction\models\Transaction;

/**
 * Class TransactionService
 * @package app\modules\transaction\services
 */
class TransactionService
{
    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * @param TransactionDTO $transactionDTO
     */
    public function setTransactionWithDTO(TransactionDTO $transactionDTO): void
    {
        $this->transaction = new Transaction();
        $this->transaction->deposit_id = $transactionDTO->getDepositId();
        $this->transaction->client_id = $transactionDTO->getClientId();
        $this->transaction->sum = $transactionDTO->getSum();
        $this->transaction->type = $transactionDTO->getType();
        $this->transaction->created_at = $transactionDTO->getCreatedAt();
    }

    /**
     * @return bool
     */
    public function saveTransaction(): bool
    {
        return $this->transaction->save(false);
    }
}