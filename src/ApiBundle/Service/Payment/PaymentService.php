<?php

declare(strict_types=1);

namespace App\ApiBundle\Service\Payment;

use App\ApiBundle\Components\PaymentProcessor\PaymentProcessor;
use App\ApiBundle\Dto\Payment\PurchaseDto;
use App\ApiBundle\Entity\Order;
use App\ApiBundle\Enum\PaymentStatus;
use App\ApiBundle\Exception\EntityNotFoundException;
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
     * @return array
     *
     * @throws EntityNotFoundException
     */
    public function execute(PurchaseDto $purchaseDto): array
    {
        $productPrice = $this->priceService->getProductPrice($purchaseDto);

        //creating an order with status
        $order = new Order();
        $order->setAmount(floatval($productPrice->getAmount()));
        $order->setStatus(PaymentStatus::PENDING);
        $order->setCurrency($productPrice->getCurrency()->getCode());
        $order->setPaymentProcessor($purchaseDto->getPaymentProcessor());

        $this->orderRepository->save($order);   // Сan be placed separately in OrderService - but within the framework of this task and its description this is not advisable

        //start payment
        $this->paymentProcessor->execute($productPrice, $purchaseDto->getPaymentProcessor());

        return [
            'orderId' => $order->getId(),
            'amount' => $order->getAmount(),
            'currency' => $order->getCurrency(),
            'status' => $order->getStatus(),
            'payment_processor' => $order->getPaymentProcessor(),
        ];
    }
}