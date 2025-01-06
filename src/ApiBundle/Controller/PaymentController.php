<?php

declare(strict_types=1);

namespace App\ApiBundle\Controller;


use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Validator\BaseValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 *  Не создавалась промежуточная таблица order_product (в качестве общей корзины)
 *  поскольку в рамках задачи это не предполагалось по условиям и смыслу.
 */
class PaymentController extends BaseController
{
    private BaseValidator $validator;

    public function __construct(BaseValidator $validator)
    {
        $this->validator = $validator;
    }

    public function calculatePrice(Request $request)
    {
        try {
            $dto = new CalculatePriceDto();
            $dto->fillFromRequest($request);

            $errors = $this->validator->validate($dto);

            if ($errors !== null) {
                return $this->json([
                    'success' => false,
                    'errors' => $errors,
                ], Response::HTTP_BAD_REQUEST);
            }


        } catch (\Exception $e) {


        }


    }

    public function purchase(Request $request)
    {

    }
}