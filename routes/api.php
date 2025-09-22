<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkSqlController;

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/

Route::get( "/drinktest", [ DrinkSqlController::class, "getDrinks" ] );
Route::get( "/drink", [ DrinkSqlController::class, "getDrink" ] );
Route::get( "/adddrink", [ DrinkSqlController::class, "addDrink" ]);
Route::get( "/updatedrink", [ DrinkSqlController::class, "updateDrink" ]);
Route::get( "/deletedrink", [ DrinkSqlController::class, "deleteDrink" ]);
Route::get( "/alldata", [ DrinkSqlController::class, "getAllData" ]);
Route::get( "/drinkdata", [ DrinkSqlController::class, "getDrinkData" ]);

