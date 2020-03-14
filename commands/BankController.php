<?php

namespace app\commands;

use app\services\FinderFactory;
use yii\console\Controller;
use app\services\BankService;
use yii\base\Module;

class BankController extends Controller
{
    /**
     * @var BankService
     */
    private $bankService;
    /**
     * @var FinderFactory
     */
    private $finderFactory;

    /**
     * BankController constructor.
     * @param $id
     * @param Module $module
     * @param BankService $bankService
     * @param FinderFactory $finderFactory
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        BankService $bankService,
        FinderFactory $finderFactory,
        array $config = []
    ) {
        parent::__construct($id, $module, $config);
        $this->bankService = $bankService;
        $this->finderFactory = $finderFactory;
    }

    public function actionIndex()
    {
        $this->finderFactory->getFinder();
    }
}
