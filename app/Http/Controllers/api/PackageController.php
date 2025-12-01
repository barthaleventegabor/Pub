<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Requests\PackageRequest;
use App\Traits\ResponseTrait;

class PackageController extends Controller {

    use ResponseTrait;

    public function getPackages() {

        $packages = Package::all();

        return $this->sendResponse( $packages );
    }

    public function create( PackageRequest $request ) {

        $request->validated();

        $package = new Package;
        $package->package = $request[ "package" ];

        $package->save();

        return $this->sendResponse( $package, "Sikeres írás" );
    }

    public function update( PackageRequest $request, $id ) {

        $request->validated();

        $package = Package::find( $id );
        if( is_null( $package )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            $package->package = $request[ "package" ];

            $package->update();

            return $this->sendResponse( $package, "Sikeres módosítás" );
        }
    }

    public function destroy( $id ) {

        $package = Package::find( $id );
        if( is_null( $package )) {

            return $this->sendError( "Nem végrehajtható", "Nincs ilyen rekord", 405 );

        }else {

            $package->delete();

            return $this->sendResponse( $package, "Sikeres törlés" );
        }
    }

    public function getPackageId( $package ) {

        $package = Package::where( "package", $package )->first();
        $id = $package->id;

        return $id;
    }
}
