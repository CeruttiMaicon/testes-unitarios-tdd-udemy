<?php 

class DiscountCalculatorTest {

    public function shouldApplyWhenValueIsAboveTheMinimumTest() {
        $discountCalculator = new DiscountCalculator();
        
        $totalValue = 130;
        $totalWithDiscount = $discountCalculator->apply($totalValue);

        
        $expectedValue = 110;
        $this->assertEquals($expectedValue, $totalWithDiscount);
    }

    public function assertEquals($expected, $actual) {
        if($expected != $actual) {
            throw new Exception('Expected ' . $expected . ' but was ' . $actual);
        }

        echo "Test passed!!!\n";
    }
}