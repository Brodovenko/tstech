<?php

use yii\db\Migration;

/**
 * Class m200312_221150_transaction
 */
class m200312_221150_transaction extends Migration
{
    public function up()
    {
        $this->createTable('transaction', [
            'id' => $this->primaryKey(),
            'deposit_id' => $this->integer(),
            'client_id' => $this->integer(),
            'type' => $this->tinyInteger(),
            'sum' => $this->float(),
            'created_at' => $this->date()
        ]);

        $this->addForeignKey(
            'fk-transaction-deposit',
            'transaction',
            'deposit_id',
            'deposit',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-transaction-client',
            'transaction',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-transaction-deposit',
            'transaction'
        );

        $this->dropForeignKey(
            'fk-transaction-client',
            'transaction'
        );

        $this->dropTable('transaction');
    }
}
