<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller {

    public function getPackages() {

        $packages = Package::all();

        return $packages;
    }

    public function create( Request $request ) {

        $package = new Package;
        $package->package = $request[ "package" ];

        $package->save();

        return $package;
    }
}
