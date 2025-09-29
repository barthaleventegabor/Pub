<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;

class DrinkController extends Controller {

    public function getDrinks() {

        $drinks = Drink::all();

        return $drinks;
    }

    public function getDrink( Request $request ) {

        //$ip = $request->ip();
        $name = $request[ "name" ];
        $drink = Drink::where( "drink", $name )->get();

        return $drink;
    }

    public function create( Request $request ) {

        $drink = new Drink;
        $drink->drink = $request[ "nev" ];
        $drink->amount = $request[ "mennyiseg" ];
        $drink->price = $request[ "ar" ];
        $drink->type_id = $request[ "tipus" ];
        $drink->package_id = $request[ "kiszereles" ];

        $drink->save();

        return $drink;
    }

    public function update( Request $request ) {

        $drink = Drink::find( $request[ "id" ]);

        $drink->drink = $request[ "nev" ];
        $drink->amount = $request[ "mennyiseg" ];
        $drink->price = $request[ "ar" ];
        $drink->type_id = $request[ "tipus" ];
        $drink->package_id = $request[ "kiszereles" ];

        $drink->update();

        return $drink;
    }

    public function destroy( $id ) {

        $drink = Drink::find( $id );
        $success = $drink->delete();

        return $success;
    }
}
