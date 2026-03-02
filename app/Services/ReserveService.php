<?php

namespace App\Services;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Reserve;
use App\Traits\ResponseTrait;
use App\Http\Resources\ReserveResource;

class ReserveService {

    /**
     * Create a new class instance.
     */
    use ResponseTrait;
    public function __construct() {}

    public function getReserves(){
        $reserves = Reserve::all();
        return $this->sendResponse( ReserveResource::collection( $reserves ) );
    }

    public function createReserve( array $validated ): ReserveResource {

        $startTime = Carbon::parse( $validated[ "start_time" ]);
        $endTime = $startTime->copy()->addHours( 2 )->subSecond();
        $user_id = Auth::user( "auth:sanctum" )->id;

        $reserved = Reserve::where( "table_number", $validated[ "table_number" ] )
            ->where( function( $query ) use ( $startTime, $endTime ) {
            $query->where("start_time", "<=", $endTime)
                ->where("end_time", ">=", $startTime);
            })->exists();

        if ( $reserved ) {
            return null;
        }


        $reserve = new Reserve();
        $reserve->table_number = $validated[ "table_number" ];
        $reserve->start_time = $startTime;
        $reserve->end_time = $endTime;
        $reserve->user_id = $user_id;
        $reserve->save();

        return (new ReserveResource( $reserve ));
    }
    
    public function update( Reserve $reserve, array $validated ) : ReserveResource {
        $time = Carbon::parse( $validated[ "start_time" ] );
        $reserve->table_number = $validated[ "table_number" ];
        $reserve->start_time = $time;
        $reserve->end_time = $time->copy()->addHours( 2 )->subSecond();
        $reserve->user_id = Auth::user( "auth:sanctum" )->id;
        $reserve->save();
        return (new ReserveResource( $reserve ));
    }

    public function delete(Reserve $reserve ) : bool{
        return $reserve->delete();
    }

}
