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
use App\Http\Resources\ReserveResource;

class ReserveController extends Controller {
    
    use ResponseTrait;
    public function __construct( protected ReserveService $reserveService ){}

    public function getReserves() {
        Gate::authorize( "viewAny", Reserve::class );
        return $this->reserveService->getReserves();
    }

    public function getReserve(Reserve $reserve) {
        Gate::authorize( "view", $reserve );
        return $this->sendResponse( $reserve );

        
    }


    public function reserveTable( ReserveRequest $request ) {
        Gate::authorize( "create", Reserve::class );
        $validated = $request->validated();

        $reserve = $this->reserveService->createReserve( $validated );
        return $this->sendResponse( $reserve, "Sikeres foglalás!" );
    }

    public function updateReserve(Reserve $reserve, ReserveRequest $request) {

        Gate::authorize( "update", $reserve );
        $validated = $request->validated();
        $reserve = $this->reserveService->update( $reserve, $validated );
        return $this->sendResponse( $reserve, "Sikeres foglalás módosítás!" );
        
    }

    public function deleteReserve(Reserve $reserve) {
        Gate::authorize( "delete", $reserve );
        $success = $this->reserveService->delete( $reserve );
        if ($success) {
            return $this->sendResponse( null, "Sikeres foglalás törlés!" );
        } else {
            return $this->sendError( "Végrehajtási hiba", ["Sikertelen törlés"],421 );
        }
    }
}
