<?php

declare(strict_types=1);

namespace App\ApiBundle\Controller;


use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Dto\Payment\PurchaseDto;
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

            $errors = $this->validator->validate($dto);

            if ($errors !== null) {
                return $this->sendJsonResponse(
                    [
                        'errors' => $errors,
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $price = $this->priceService->getPrice($dto);
        } catch (\Exception $e) {

        }

        return $this->sendJsonResponse(['price' => $price]);
    }

    public function purchase(Request $request): JsonResponse
    {
        try {
            $dto = new PurchaseDto();
            $dto->fillFromRequest($request);

            $errors = $this->validator->validate($dto);

            if ($errors !== null) {
                return $this->sendJsonResponse(
                    [
                        'errors' => $errors,
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $this->paymentService->execute($dto);
        } catch (\Exception $e) {

        }

        return $this->sendJsonResponse();
    }
}