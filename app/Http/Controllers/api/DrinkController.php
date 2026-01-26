<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Requests\DrinkRequest;
use App\Http\Resources\DrinkResource;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Gate;
use App\Services\DrinkService;

class DrinkController extends Controller {

    use ResponseTrait;
    protected DrinkService $drinkService;
    
    public function __construct( DrinkService $drinkService ) {

        $this->drinkService = $drinkService;
    }
    public function getDrinks() {

        Gate::authorize( "viewAny", Drink::class );

        $drinks = Drink::with( "type", "package" )->get();

        return $this->sendResponse( DrinkResource::collection( $drinks ), "" );
    }

    public function getDrink( Drink $drink ) {

        Gate::authorize( "view", $drink );
        //$ip = $request->ip();
        return $this->sendResponse( ( new DrinkResource( $drink )), "" );
    }

    public function create( DrinkRequest $request ) {

        Gate::authorize( "create", Drink::class );
        $validated = $request->validated();

        return $this->drinkService->create( $validated );
    }

    public function update( DrinkRequest $request, Drink $drink ) {

        Gate::authorize( "update", $drink );
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

        Gate::authorize( "delete", $drink );
        //$drink->delete();
        
        return $this->sendResponse( $drink, "Sikeres törlés" );
    }
}
