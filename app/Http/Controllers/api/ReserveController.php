<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ReserveRequest;
use App\Policies\ReservePolicy;
use App\Services\ReserveService;
use App\Traits\ResponseTrait;
use App\Models\Reserve;
use Illuminate\Support\Facades\Gate;

class ReserveController extends Controller {
    
    use ResponseTrait;
    public function __construct( protected ReserveService $reserveService ){}

    public function getReserves() {
        Gate::authorize( "viewAny", Reserve::class );
        $reserves = Reserve::all();
        return $this->sendResponse( $reserves );
    }

    public function getReserve(Reserve $reserve) {
        Gate::authorize( "view", $reserve );
        return $this->sendResponse( $reserve );

        
    }


    public function reserveTable( ReserveRequest $request ) {
        Gate::authorize( "create", Reserve::class );
        $validated = $request->validated();

        $reserve = $this->reserveService->createReserve( $validated );
        return $this->sendResponse( $reserve , "Sikeres foglalás!" );
    }

    public function updateReserve() {
        
    }

    public function deleteReserve() {
        
    }
}
