<?php
declare(strict_types=1);

namespace App\Tests\Controller;

use App\ApiBundle\Dto\Payment\PurchaseDto;
use PHPUnit\Framework\TestCase;

use App\ApiBundle\Controller\PaymentController;
use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Exception\EntityNotFoundException;
use App\ApiBundle\Service\Payment\PaymentService;
use App\ApiBundle\Service\Payment\PriceService;
use App\ApiBundle\Validator\BaseValidator;
use Money\Currency;
use Money\Money;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class PaymentControllerTest extends TestCase
{
    private BaseValidator $validator;
    private PriceService $priceService;
    private PaymentService $paymentService;
    private PaymentController $controller;

    protected function setUp(): void
    {
        $this->validator = $this->createMock(BaseValidator::class);
        $this->priceService = $this->createMock(PriceService::class);
        $this->paymentService = $this->createMock(PaymentService::class);

        $this->controller = new PaymentController(
            $this->validator,
            $this->priceService,
            $this->paymentService
        );
    }

    public function testCalculatePriceSuccess(): void
    {
        // Иметируем запрос
        $request = new Request(content: json_encode([
            'product' => 1,
            'taxNumber' => "DE123456789",
            'couponCode' => 'D15',
        ]));
        // Мокаем dto
        $dto = $this->createMock(CalculatePriceDto::class);
        $dto->method('fillFromRequest')->with($request);
        // иметируем заполнение
        $dto->method('getProduct')->willReturn(1);
        $dto->method('getTaxNumber')->willReturn('DE123456789');
        $dto->method('getCouponCode')->willReturn('D15');

        // проверяем что заполняется
        $this->assertEquals(1, $dto->getProduct());
        $this->assertEquals("DE123456789", $dto->getTaxNumber());
        $this->assertEquals('D15', $dto->getCouponCode());

        // Мокаем валидатор (проверка успешно проходит)
        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isInstanceOf(CalculatePriceDto::class));

        // Мокаем PriceService
        $this->priceService->expects($this->once())
            ->method('getProductPrice')
            ->with($this->isInstanceOf(CalculatePriceDto::class))
            ->willReturn(new Money(1000, new Currency('EUR')));

        // Вызываем метод контроллера
        $response = $this->controller->calculatePrice($request);

        // Проверяем, что ответ правильный
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'price' => "1000",
            'currency' => 'EUR',
        ]), $response->getContent());
    }

    public function testCalculatePriceValidationError(): void
    {
        // Иметируем тестовый не полный запрос
        $request = new Request(content: json_encode([
            'product' => 1,
        ]));

        // Мокаем валидатор (выбрасывает ValidationException)
        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isInstanceOf(CalculatePriceDto::class))
            ->willThrowException(new \App\ApiBundle\Exception\ValidationException());

        // Вызываем метод контроллера
        $response = $this->controller->calculatePrice($request);

        // Проверяем, что вернулся корректный ответ об ошибке
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'errors' => [],
            'message' => "Validation failed",
            'code' => 422
        ]), $response->getContent());
    }

    public function testCalculatePriceEntityNotFound(): void
    {
        // Иметируем тестовый запрос c неполной сущностью
        $request = new Request(content: json_encode([
            'product' => 999,
            'taxNumber' => 'DE123456789',
            'couponCode' => 'D15',
        ]));

        // Мокаем PriceService (выбрасывает EntityNotFoundException)
        $this->priceService->expects($this->once())
            ->method('getProductPrice')
            ->willThrowException(new EntityNotFoundException());

        // Вызываем метод контроллера
        $response = $this->controller->calculatePrice($request);

        // Проверяем, что вернулся корректный ответ об ошибке
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'errors' => [],
            'message' => "Entity not found.",
            'code' => 404
        ]), $response->getContent());
    }

    public function testPurchaseSuccess(): void
    {
        // Иметируем запрос
        $request = new Request(content: json_encode([
            'product' => 1,
            'taxNumber' => "DE123456789",
            'couponCode' => 'D15',
            'paymentProcessor' => 'stripe'
        ]));

        // Мокаем dto
        $dto = $this->createMock(PurchaseDto::class);
        $dto->method('fillFromRequest')->with($request);
        // иметируем заполнение
        $dto->method('getProduct')->willReturn(1);
        $dto->method('getTaxNumber')->willReturn('DE123456789');
        $dto->method('getCouponCode')->willReturn('D15');
        $dto->method('getPaymentProcessor')->willReturn('stripe');

        // проверяем что заполняется
        $this->assertEquals(1, $dto->getProduct());
        $this->assertEquals("DE123456789", $dto->getTaxNumber());
        $this->assertEquals('D15', $dto->getCouponCode());
        $this->assertEquals('stripe', $dto->getPaymentProcessor());

        // Мокаем валидатор (проверка успешно проходит)
        $this->validator->expects($this->once())
            ->method('validate')
            ->with($this->isInstanceOf(PurchaseDto::class));

        // Мокаем PaymentService
        $this->paymentService->expects($this->once())
            ->method('execute')
            ->with($this->isInstanceOf(PurchaseDto::class))
            ->willReturn(
                [
                    'orderId' => 75,
                    'amount' => 23,
                    'currency' => "EUR",
                    'status' => "pending",
                    'payment_processor' => "stripe",
                ]
            );

        // Вызываем метод контроллера
        $response = $this->controller->purchase($request);

        // Проверяем, что ответ правильный
        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertJsonStringEqualsJsonString(json_encode([
            'orderId' => 75,
            'amount' => 23,
            'currency' => "EUR",
            'status' => "pending",
            'payment_processor' => "stripe",
        ]), $response->getContent());
    }
}