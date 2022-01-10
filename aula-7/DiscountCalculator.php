<?php

class DiscountCalculator
{

    const MINUMUN_VALUE = 100;
    const DISCOUNT_VALUE = 100;

    public function apply($value)
    {
        if($value >= self::MINUMUN_VALUE) {
            return $value - self::DISCOUNT_VALUE;
        }

        return $value;
    }
}