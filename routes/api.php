<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkSqlController;
use App\Http\Controllers\api\DrinkBuilderController;
use App\Http\Controllers\api\DrinkController;
use App\Http\Controllers\api\PackageController;


/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

// Route::get( "/drinktest", [ DrinkSqlController::class, "getDrinks" ] );
// Route::get( "/drink", [ DrinkSqlController::class, "getDrink" ] );
// Route::get( "/adddrink", [ DrinkSqlController::class, "addDrink" ]);
// Route::get( "/updatedrink", [ DrinkSqlController::class, "updateDrink" ]);
// Route::get( "/deletedrink", [ DrinkSqlController::class, "deleteDrink" ]);
// Route::get( "/alldata", [ DrinkSqlController::class, "getAllData" ]);
// Route::get( "/drinkdata", [ DrinkSqlController::class, "getDrinkData" ]);

// Route::get( "/drinktest", [ DrinkBuilderController::class, "getDrinks" ] );
// Route::get( "/drinkselect", [ DrinkBuilderController::class, "getSelectDrinks" ] );
// Route::get( "/drink", [ DrinkBuilderController::class, "getDrink" ] );
// Route::get( "/adddrink", [ DrinkBuilderController::class, "addDrink" ]);
// Route::get( "/updatedrink", [ DrinkBuilderController::class, "updateDrink" ]);
// Route::get( "/modifydrink", [ DrinkBuilderController::class, "modifyDrink" ]);
// Route::get( "/deletedrink/{id}", [ DrinkBuilderController::class, "deleteDrink" ]);
// Route::get( "/alldata", [ DrinkBuilderController::class, "getAllData" ]);
// Route::get( "/drinkdata", [ DrinkBuilderController::class, "getDrinkData" ]);
// Route::get( "/drinkdate", [ DrinkBuilderController::class, "getDates" ]);
// Route::get( "/palinka", [ DrinkBuilderController::class, "getPalinka" ]);

Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getDrink" ]);
Route::post( "/new", [ DrinkController::class, "create" ]);
Route::put( "/update", [ DrinkController::class, "update" ]);
Route::delete( "/delete/{id}", [ DrinkController::class, "destroy" ]);

Route::get( "/packages", [ PackageController::class, "getPackages" ]);
Route::post( "/create", [ PackageController::class, "create" ]);
