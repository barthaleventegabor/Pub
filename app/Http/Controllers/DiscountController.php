<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class DiscountController extends Controller {
    
    public function calculateDiscount( int $value, int  $percent ) {

        if( $percent < 0 || $percent > 100 ) {

            throw new InvalidArgumentException( "Rossz százalék érték." );
        }

        return $value - ( $value * ( $percent / 100 ));
    }
}
