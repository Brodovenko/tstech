<?php

namespace app\services;

use app\modules\deposit\services\Commission;
use app\modules\deposit\services\DepositAccrual;

class FinderFactory
{
    /**
     * @var BankService
     */
    private $bankService;
    /**
     * @var FinderDepositService
     */
    private $finderDepositService;
    /**
     * @var FinderCommissionService
     */
    private $finderCommissionService;

    /**
     * FinderFactory constructor.
     * @param BankService $bankService
     * @param FinderDepositService $finderDepositService
     * @param FinderCommissionService $finderCommissionService
     */
    public function __construct(
        BankService $bankService,
        FinderDepositService $finderDepositService,
        FinderCommissionService $finderCommissionService
    ) {
        $this->bankService = $bankService;
        $this->finderDepositService = $finderDepositService;
        $this->finderCommissionService = $finderCommissionService;
    }

    /**
     * @throws \Exception
     */
    public function getFinder()
    {
        $currDay = new \DateTime();

        if ($currDay->format('d') == 1) {
            foreach ($this->finderDepositService->getDeposits() as $deposit) {
                $this->bankService->setDeposit($deposit);
                $this->bankService->setBalanceChangeStrategy(new DepositAccrual());
                $this->bankService->changeDeposit();
            }

            foreach ($this->finderCommissionService->getDeposits() as $deposit) {
                $this->bankService->setDeposit($deposit);
                $this->bankService->setBalanceChangeStrategy(new Commission());
                $this->bankService->changeDeposit();
            }
        } else {
            foreach ($this->finderDepositService->getDeposits() as $deposit) {
                $this->bankService->setDeposit($deposit);
                $this->bankService->setBalanceChangeStrategy(new DepositAccrual());
                $this->bankService->changeDeposit();
            }
        }
    }
}