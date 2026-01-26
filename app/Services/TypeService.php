<?php

namespace App\Services;

use App\Models\Type;
use App\Traits\ResponseTrait;

class TypeService {

    use ResponseTrait;

    public function __construct(){
    }

    public function getTypeId( $name ) {

        $type = Type::where( "type", $name )->first();
        $id = $type->id;

        return $id;
    }
}
