<?php
declare(strict_types=1);

namespace App\ApiBundle\Service\Payment;

use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Entity\Coupon;
use App\ApiBundle\Entity\Product;
use App\ApiBundle\Entity\Tax;
use App\ApiBundle\Enum\CouponType;
use App\ApiBundle\Exception\EntityNotFoundException;
use App\ApiBundle\Repository\CouponRepository;
use App\ApiBundle\Repository\ProductRepository;
use App\ApiBundle\Repository\TaxRepository;
use Money\Money;
use Money\Currency;

class PriceService
{
    public function __construct(
        private readonly CouponRepository  $couponRepository,
        private readonly ProductRepository $productRepository,
        private readonly TaxRepository     $taxRepository,
    )
    {
    }

    /**
     * @param CalculatePriceDto $calculatePriceDto
     *
     * @return Money
     *
     * @throws EntityNotFoundException
     */
    public function getProductPrice(CalculatePriceDto $calculatePriceDto): Money
    {
        /** @var Product $product */
        $product = $this->productRepository->find($calculatePriceDto->getProduct());

        if ($product === null) {
            throw new EntityNotFoundException();
        }

        $amount = new Money($product->getAmount(), new Currency($product->getCurrency()));
        $discount = $this->getDiscountByType($calculatePriceDto, $amount);
        $taxAmount = $this->getTaxAmount($amount, $calculatePriceDto->getTaxNumber());

        return $amount->add($taxAmount)->subtract($discount);
    }

    // !! In these methods you can use separate services where the corresponding logic will be implemented (carrying out the logic into services)
    //Within the framework of the project this would be true, but within the framework of one test task it doesn’t make sense to go deeper and I’ll describe the logic right here
    /**
     * @param Money $amount
     * @param string $taxNumber
     *
     * @return Money
     *
     * @throws EntityNotFoundException
     */
    private function getTaxAmount(Money $amount, string $taxNumber): Money
    {
        $countryCode = substr($taxNumber, 0, 2);
        /** @var Tax $tax */
        $tax = $this->taxRepository->getByCountryCode($countryCode);

        if ($tax === null) {
            throw new EntityNotFoundException();
        }

        return $amount->multiply($tax->getPercent() / 100);
    }

    // same case !
    /**
     * @param CalculatePriceDto $calculatePriceDto
     * @param Money $amount
     *
     * @return Money
     *
     * @throws EntityNotFoundException
     */
    private function getDiscountByType(CalculatePriceDto $calculatePriceDto, Money $amount): Money
    {
        /** @var  Coupon $coupon */
        $coupon = $this->couponRepository->findByCode($calculatePriceDto->getCouponCode());

        if ($coupon === null) {
            throw new EntityNotFoundException();
        }

        return match ($coupon->getType()) {
            CouponType::PERCENT => $amount->multiply($coupon->getDiscountAmount() / 100),
            CouponType::FIXED_AMOUNT => new Money($coupon->getDiscountAmount(), $amount->getCurrency()),
        };
    }
}