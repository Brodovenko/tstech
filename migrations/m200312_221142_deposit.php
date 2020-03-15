<?php

use yii\db\Migration;

/**
 * Class m200312_221142_deposit
 */
class m200312_221142_deposit extends Migration
{
    public function up()
    {
        $this->createTable('deposit', [
            'id' => $this->primaryKey(),
            'client_id' => $this->integer(),
            'balance' => $this->float(),
            'percent' => $this->integer(),
            'created_at' => $this->date(),
            'updated_at' => $this->date(),
        ]);

        $this->addForeignKey(
            'fk-deposit-client',
            'deposit',
            'client_id',
            'client',
            'id',
            'CASCADE'
        );

        $this->batchInsert('deposit',
            [
                'id',
                'client_id',
                'balance',
                'percent',
                'created_at',
            ],
            [
                [
                    1,
                    1,
                    1000,
                    10,
                    '2020-02-16',
                ],
                [
                    2,
                    1,
                    2000,
                    12,
                    '2020-02-16',
                ],
                [
                    3,
                    2,
                    3000,
                    14,
                    '2020-02-17',
                ],
            ]);
    }

    public function down()
    {
        $this->dropForeignKey(
            'fk-deposit-client',
            'deposit'
        );

        $this->dropTable('deposit');
    }
}
