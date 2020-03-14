<?php

use yii\db\Migration;

/**
 * Class m200312_220358_client
 */
class m200312_220358_client extends Migration
{
    public function up()
    {
        $this->createTable('client', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'second_name' => $this->string()->notNull(),
            'gender' => $this->tinyInteger(2),
            'birthday' => $this->date(),
            'created_at' => $this->date(),
            'updated_at' => $this->date(),
        ]);

        $this->batchInsert('client',
            [
                'id',
                'name',
                'second_name',
                'gender',
                'birthday',
                'created_at',
                'updated_at'
            ],
            [
                [
                    '1',
                    'Ivan',
                    'Kozak',
                    1,
                    '1999-15-15',
                    '2019-10-14',
                    '2020-02-14',
                ],
                [
                    '2',
                    'Oleg',
                    'Spivak',
                    1,
                    '1995-15-15',
                    '2019-11-14',
                    '2020-01-14',
                ]
            ]);
    }

    public function down()
    {
        $this->dropTable('client');
    }
}
