<?php

declare(strict_types=1);

namespace App\ApiBundle\Controller;


use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Dto\Payment\PurchaseDto;
use App\ApiBundle\Exception\BadRequestException;
use App\ApiBundle\Exception\EntityNotFoundException;
use App\ApiBundle\Exception\ValidationException;
use App\ApiBundle\Service\Payment\PaymentService;
use App\ApiBundle\Service\Payment\PriceService;
use App\ApiBundle\Validator\BaseValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Не создавалась промежуточная таблица order_product (в качестве общей корзины)
 *  поскольку в рамках задачи это не предполагалось по условиям и смыслу.
 */
class PaymentController extends BaseController
{
    public function __construct(
        private BaseValidator $validator,
        private PriceService $priceService,
        private PaymentService $paymentService,
    )
    {
    }

    public function calculatePrice(Request $request): JsonResponse
    {
        try {
            $dto = new CalculatePriceDto();
            $dto->fillFromRequest($request);

            $this->validator->validate($dto);

            $productPrice = $this->priceService->getProductPrice($dto);

            return $this->sendJsonResponse([
                'price' => $productPrice->getAmount(),
                'currency' => $productPrice->getCurrency()->getCode()
            ]);
        } catch (BadRequestException|ValidationException|EntityNotFoundException $e) {
            return $this->sendJsonResponse($e->getData(),
                $e->getCode()
            );
        }
    }

    public function purchase(Request $request): JsonResponse
    {
        try {
            $dto = new PurchaseDto();
            $dto->fillFromRequest($request);

            $this->validator->validate($dto);

            $result = $this->paymentService->execute($dto);

            return $this->sendJsonResponse($result, Response::HTTP_CREATED);
        } catch (BadRequestException|ValidationException|EntityNotFoundException $e) {
            return $this->sendJsonResponse($e->getData(),
                $e->getCode()
            );
        }
    }
}