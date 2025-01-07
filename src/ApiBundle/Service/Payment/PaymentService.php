<?php

declare(strict_types=1);

namespace App\ApiBundle\Service\Payment;

use App\ApiBundle\Components\PaymentProcessor\PaymentProcessor;
use App\ApiBundle\Dto\Payment\PurchaseDto;
use App\ApiBundle\Enum\PaymentStatus;
use App\ApiBundle\Repository\OrderRepository;

/**
 * In-app purchase process service.
 */
class PaymentService
{
    public function __construct(
        private PriceService     $priceService,
        private PaymentProcessor $paymentProcessor,
        private OrderRepository $orderRepository,
    )
    {
    }

    /**
     *
     * @param PurchaseDto $purchaseDto
     * @return void
     */
    public function execute(PurchaseDto $purchaseDto): void
    {
        $price = $this->priceService->getPrice($purchaseDto);

        //creating an order with status
        $this->orderRepository->addOrder($price, PaymentStatus::PENDING);
        //start payment
        $this->paymentProcessor->execute($price, $purchaseDto->getPaymentProcessor());

    }
}