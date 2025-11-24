<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\DrinkSqlController;
use App\Http\Controllers\api\DrinkBuilderController;
use App\Http\Controllers\api\DrinkController;
use App\Http\Controllers\api\PackageController;
use App\Http\Controllers\api\TypeController;
use App\Http\Controllers\api\UserController;
use App\Http\Controllers\api\AdminController;


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


//Drink
Route::get( "/drinks", [ DrinkController::class, "getDrinks" ]);
Route::get( "/drink", [ DrinkController::class, "getDrink" ]);
Route::post( "/newdrink", [ DrinkController::class, "create" ]);
Route::put( "/updatedrink/{id}", [ DrinkController::class, "update" ]);
Route::delete( "/deletedrink/{id}", [ DrinkController::class, "destroy" ]);

//Package
Route::get( "/packages", [ PackageController::class, "getPackages" ]);
Route::post( "newpackage", [ PackageController::class, "create" ]);
Route::put( "/updatepackage/{id}", [ PackageController::class, "update" ]);
Route::delete( "deletepackage/{id}", [ PackageController::class, "destroy" ]);

//Type
Route::get( "/types", [ TypeController::class, "getTypes" ]);
Route::post( "/newtype", [ TypeController::class, "create" ]);
Route::put( "/updatetype/{id}", [ TypeController::class, "update" ]);
Route::delete( "/deletetype/{id}", [ TypeController::class, "destroy" ]);

//User
Route::post( "/register", [ UserController::class, "register" ]);
Route::post( "/login", [ UserController::class, "login" ]);
Route::post( "/logout", [ UserController::class, "logout" ]);

//Admin
Route::get( "/users", [ AdminController::class, "getUsers" ]);
Route::get( "/addadmin/{id}", [ AdminController::class, "setAdminRole" ]);
Route::get( "/deladmin/{id}", [ AdminController::class, "delAdminRole" ]);
Route::post( "/newuser/{role?}", [ AdminController::class, "newUser" ]);
Route::put( "/setpassword/{id}", [ AdminController::class, "setPassword" ]);
Route::get( "/token", [ AdminController::class, "getTokens" ]);
