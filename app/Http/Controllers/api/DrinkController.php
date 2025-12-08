<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Requests\DrinkRequest;
use App\Http\Resources\DrinkResource;
use App\Traits\ResponseTrait;

class DrinkController extends Controller {

    use ResponseTrait;
    
    public function getDrinks() {

        $drinks = Drink::with( "type", "package" )->get();

        return $this->sendResponse( DrinkResource::collection( $drinks ), "" );
    }

    public function getDrink( Request $request ) {

        //$ip = $request->ip();
        $name = $request[ "drink" ];
        $drink = Drink::where( "drink", $name )->first();

        return $this->sendResponse( ( new DrinkResource( $drink )), "" );
    }

    public function create( DrinkRequest $request ) {

        $request->validated();

        $drink = new Drink;
        $drink->drink = $request[ "drink" ];
        $drink->amount = $request[ "amount" ];
        $drink->price = $request[ "price" ];
        $drink->type_id = ( new TypeController )->getTypeId( $request[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $request[ "package" ]);

        $drink->save();

        return $this->sendResponse( $drink, "Sikeres kiírás" );
    }

    public function update( DrinkRequest $request, $id ) {

        $request->validated();

        $drink = Drink::find( $id );
        if( is_null( $drink )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            $drink->drink = $request[ "drink" ];
            $drink->amount = $request[ "amount" ];
            $drink->price = $request[ "price" ];
            $drink->type_id = ( new TypeController )->getTypeId( $request[ "type" ]);
            $drink->package_id = ( new PackageController )->getPackageId( $request[ "package" ]);

            $drink->update();

            return $this->sendResponse( $drink, "Sikeres frissítés" );
        }
    }

    public function destroy( $id ) {

        $drink = Drink::find( $id );
        if( is_null( $drink )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            $drink->delete();

            return $this->sendResponse( $drink, "Sikeres törlés" );
        }
    }
}
