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

    public function getDrink( Drink $drink ) {

        //$ip = $request->ip();
        return $this->sendResponse( ( new DrinkResource( $drink )), "" );
    }

    public function create( DrinkRequest $request ) {

        //Servicebe kiszervezni
        $validated = $request->validated();

        $drink = new Drink();
        $drink->drink = $validated[ "drink" ];
        $drink->amount = $validated[ "amount" ];
        $drink->price = $validated[ "price" ];
        $drink->type_id = ( new TypeController )->getTypeId( $validated[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $validated[ "package" ]);

        $drink->save();

        return $this->sendResponse( $drink, "Sikeres kiírás" );
    }

    public function update( DrinkRequest $request, Drink $drink ) {

        //Servicebe kivezetni
        $validated = $request->validated();

        $drink->drink = $validated[ "drink" ];
        $drink->amount = $validated[ "amount" ];
        $drink->price = $validated[ "price" ];
        $drink->type_id = ( new TypeController )->getTypeId( $validated[ "type" ]);
        $drink->package_id = ( new PackageController )->getPackageId( $validated[ "package" ]);

        $drink->update();

        return $this->sendResponse( $drink, "Sikeres frissítés" );
    }

    public function destroy( Drink $drink ) {

        $drink->delete();
        
        return $this->sendResponse( $drink, "Sikeres törlés" );
    }
}
