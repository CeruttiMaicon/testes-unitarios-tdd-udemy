<?php 

class DiscountCalculatorTest {

    public function ShouldApply_WhenValueIsAboveTheMinimumTest() {

        $discountCalculator = new DiscountCalculator();

        $totalValue = 130;
        $totalWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 110;
        $this->assertEquals($expectedValue, $totalWithDiscount);
    }

    public function ShoulNotdApply_WhenValueIsBellowTheMinimumTest() {

        $discountCalculator = new DiscountCalculator();

        $totalValue = 90;
        $totalWithDiscount = $discountCalculator->apply($totalValue);

        $expectedValue = 90;
        $this->assertEquals($expectedValue, $totalWithDiscount);
    }

    public function assertEquals($expected, $actual) {
        
        if ($expected !== $actual) {
            $message = 'Expected: ' . $expected . ' but got: ' . $actual;
            throw new \Exception($message);
        }

        echo "Test passed!!!\n";
    }
}