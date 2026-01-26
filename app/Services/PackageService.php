<?php

namespace App\Services;

use App\Models\Package;
use App\Traits\ResponseTrait;

class PackageService {
    
    use ResponseTrait;

    public function __construct() {
        
    }

    public function getPackageId( $name ) {

        $package = Package::where( "package", $name )->first();
        $id = $package->id;

        return $id;
    }
}
