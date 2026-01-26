<?php

namespace App\Services;

use App\Models\Drink;
use App\Traits\ResponseTrait;

class DrinkService {
    
    use ResponseTrait;
    protected PackageService $packageService;
    protected TypeService $typeService;

    public function __construct( PackageService $packageService, TypeService $typeService ) {
        
        $this->packageService = $packageService;
        $this->typeService = $typeService;
    }

    public function create( $data ) {

        $drink = new Drink();
        $drink->drink = $data[ "drink" ];
        $drink->amount = $data[ "amount" ];
        $drink->price = $data[ "price" ];
        $drink->type_id = $this->typeService->getTypeId( $data[ "type" ]);
        $drink->package_id = $this->packageService->getPackageId( $data[ "package" ]);

        //$drink->save();

        return $this->sendResponse( $drink, "Sikeres írás" );
    }

    public function update() {

    }

    public function delete() {


    }
}
