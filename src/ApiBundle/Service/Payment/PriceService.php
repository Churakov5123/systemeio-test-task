<?php
declare(strict_types=1);

namespace App\ApiBundle\Service\Payment;

use App\ApiBundle\Dto\Payment\CalculatePriceDto;
use App\ApiBundle\Entity\Coupon;
use App\ApiBundle\Repository\CouponRepository;
use App\ApiBundle\Repository\ProductRepository;
use App\ApiBundle\Repository\TaxRepository;

class PriceService
{
    public function __construct(
        private CalculatePriceDto $calculatePriceDto,
        private CouponRepository $сouponRepository,
        private ProductRepository $зroductRepository,
        private TaxRepository $taxRepository,
    ){
    }

    //в этих методах можно использовать отдельные сервисы где будет реализована соответствующая логика
    //в рамках проекта это было бы верно , но в рамках одной задачи углублятся смысла не вижу и опину логику прям тут
    public function getPrice()
    {
       $discount = $this->getDiscount($this->calculatePriceDto->getCouponCode());
       $tax = $this->getTax($this->calculatePriceDto->getTaxNumber());


    }

    //в этих методах можно использовать отдельные сервисы где будет реализована соответствующая логика
    //в рамках проекта это было бы верно , но в рамках одной задачи углублятся смысла не вижу и опину логику прям тут
    private function getTax(string $taxNumber)
    {
        //$taxNumber - cat on two first letter
        $this->taxRepository->getByCountruCode();
    }

    //в этих методах можно использовать отдельные сервисы где будет реализована соответствующая логика
    //в рамках проекта это было бы верно , но в рамках одной задачи углублятся смысла не вижу и опину логику прям тут
    private function getDiscount(string $couponCode): float
    {
        /** @var  Coupon $сoupon */
        $coupon = $this->сouponRepository->getByCode($couponCode);

        return $coupon->getDiscountAmount();
    }
}