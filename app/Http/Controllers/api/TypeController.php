<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Requests\TypeRequest;
use App\Traits\ResponseTrait;

class TypeController extends Controller {

    use ResponseTrait;

    public function getTypes() {

        $types = Type::all();

        return $this->sendResponse( $types );
    }

    public function create( TypeRequest $request ) {

        $request->validated();

        $type = new Type();
        $type->type = $request[ "type" ];

        //$type->save();

        return $this->sendResponse( $type, "Sikeres írás" );
    }

    public function update( TypeRequest $request, $id ) {

        $request->validated();

        $type = Type::find( $id );
        if( is_null( $type )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            $type->type = $request[ "type" ];

            $type->update();

            return $this->sendResponse( $type, "Sikeres módosítás" );
        }

    }

    public function destroy( $id ) {

        $type = Type::find( $id );

        if( is_null( $type )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            //$type->delete();

            return $this->sendResponse( $type, "Sikeres törlés" );
        }
    }

    public function getTypeId( $type ) {

        $type = Type::where( "type", $type )->first();
        $id = $type->id;

        return $id;
    }
}
