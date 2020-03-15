<?php

namespace app\controllers;

use app\services\BankService;
use app\services\FinderFactory;
use yii\base\Module;
use yii\web\Controller;

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

    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->finderFactory->getFinder();
    }
}
