<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Http\Controllers\DiscountController;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class DiscountCalculatorTest extends TestCase {
    
    public function test_calculates_discount_correctly() {

        $calculator = new DiscountController();

        $result = $calculator->calculateDiscount( 1000, 20 );
        $this->assertEquals( 800, $result );

        $result = $calculator->calculateDiscount( 1000, 1 );
        $this->assertEquals( 990, $result );

        $result = $calculator->calculateDiscount( 1000, 100 );
        $this->assertEquals( 0, $result );
    }

    public function test_throws_exception_when_invalid_discount() {

        $calculator = new DiscountController();

        $this->expectException( InvalidArgumentException::class );

        $calculator->calculateDiscount( 1000, -10 );
        $calculator->calculateDiscount( 1000, 0 );
        $calculator->calculateDiscount( 1000, -101 );
    }
}
