<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkSqlController;
use App\Http\Controllers\api\DrinnkBuilderController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get("/drinktest", [DrinkSqlController::class,"getDrinks"]);

// Route::get("/drink", [DrinkSqlController::class,"getDrink"]);

// Route::get("/adddrink",[DrinkSqlController::class,"addDrink"]);

// Route::get("/updatedrink",[DrinkSqlController::class,"updateDrink"]);


// Route::get("/deletedrink",[DrinkSqlController::class,"deleteDrink"]);

// Route::get("/alldata",[DrinkSqlController::class,"getAllData"]);

// Route::get("/getdrinkdata",[DrinkSqlController::class,"getDrinkData"]);


Route::get("/drinktest", [DrinnkBuilderController::class,"getDrinks"]);

Route::get("/drinkselect", [DrinnkBuilderController::class,"getSelectDrinks"]);

Route::get("/adddrink",[DrinnkBuilderController::class,"addDrink"]);

Route::get("/getdrink",[DrinnkBuilderController::class,"getDrink"]);

Route::get("/getfounddrink",[DrinnkBuilderController::class,"getFoundDrink"]);

Route::get("/updatedrink",[DrinnkBuilderController::class,"updateDrink"]);

Route::get("/modifydrink",[DrinnkBuilderController::class,"modifyDrink"]);


Route::get("/deletedrinks/{id}",[DrinnkBuilderController::class,"deleteDrinks"]);

Route::get("/alldata",[DrinnkBuilderController::class,"getAllData"]);

Route::get("/drinkdata",[DrinnkBuilderController::class,"getDrinkData"]);

Route::get("/palinka",[DrinnkBuilderController::class,"getPalinka"]);


