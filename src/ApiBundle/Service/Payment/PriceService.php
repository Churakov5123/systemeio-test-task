<?php
declare(strict_types=1);

namespace App\ApiBundle\Service\Payment;

use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Entity\Coupon;
use App\ApiBundle\Entity\Product;
use App\ApiBundle\Entity\Tax;
use App\ApiBundle\Enum\CouponType;
use App\ApiBundle\Repository\CouponRepository;
use App\ApiBundle\Repository\ProductRepository;
use App\ApiBundle\Repository\TaxRepository;

class PriceService
{
    public function __construct(
        private readonly CouponRepository  $couponRepository,
        private readonly ProductRepository $productRepository,
        private readonly TaxRepository     $taxRepository,
    )
    {
    }

    public function getPrice(CalculatePriceDto $calculatePriceDto): float
    {
        /** @var Product $product */
        $product = $this->productRepository->getByProduct($calculatePriceDto->getProduct());
        $productAmount = $product->getAmount();

        $discount = $this->getDiscountByType($calculatePriceDto, $productAmount);

        $taxPercent = $this->getTax($calculatePriceDto->getTaxNumber());

        return $productAmount + ($productAmount / 100 * $taxPercent) - $discount;
    }

    //В этих методах можно использовать отдельные сервисы где будет реализована соответствующая логика
    //В рамках проекта это было бы верно, но в рамках одного  тестового задания  углублятся смысла не вижу и опишу логику прям тут
    private function getTax(string $taxNumber): int
    {
        $countryCode = substr($taxNumber, 2);
        /** @var Tax $tax */
        $tax = $this->taxRepository->getByCountryCode($countryCode);

        return $tax->getPercent();
    }

    //В этих методах можно использовать отдельные сервисы где будет реализована соответствующая логика
    //В рамках проекта это было бы верно, но в рамках одного  тестового задания  углублятся смысла не вижу и опишу логику прям тут
    private function getDiscountByType(CalculatePriceDto $calculatePriceDto, float $amount): float
    {
        /** @var  Coupon $coupon */
        $coupon = $this->couponRepository->getByCode($calculatePriceDto->getCouponCode());

        return match ($coupon->getType()) {
            CouponType::PERCENT => $amount / 100 * $coupon->getDiscountAmount(),
            CouponType::FIXED_AMOUNT => $coupon->getDiscountAmount(),
        };
    }
}