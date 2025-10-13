<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;

class DrinkController extends ResponseController {

    public function getDrinks() {

        $drinks = Drink::all();

        return $this->sendResponse( $drinks, "Betöltés rendben" );
    }

    public function getDrink( Request $request ) {

        //$ip = $request->ip();
        $name = $request[ "drink" ];
        $drink = Drink::where( "drink", $name )->first();

        return $this->sendResponse(  $drink, "Egy ital" );
    }

    public function create( Request $request ) {

        $drink = new Drink;
        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->price = $request[ "price" ];
        $drink->type_id = $request[ "type_id" ];
        $drink->package_id = $request[ "package_id" ];

        $drink->save();

        return $this->sendResponse( $drink, "Sikeres kiírás" );
    }

    public function update( Request $request ) {

        $drink = Drink::find( $request[ "id" ]);

        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->price = $request[ "price" ];
        $drink->type_id = $request[ "type_id" ];
        $drink->package_id = $request[ "package_id" ];

        $drink->update();

        return $this->sendResponse( $drink, "Sikeres frissítés" );
    }

    public function destroy( $id ) {

        $drink = Drink::find( $id );
        $success = $drink->delete();

        return $this->sendResponse( $drink, "Sikeres törlés" );
    }
}
