<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DrinkSqlController extends Controller {

    public function getDrinks() {

        $sql = "SELECT * FROM drinks";

        $drinks = DB::select( $sql );

        return $drinks;
    }

    public function getDrink() {

        $sql = "SELECT drink FROM drinks where id = 48";

        $drink = DB::select( $sql );

        return $drink;
    }

    public function addDrink() {

        $sql  = "INSERT INTO drinks( drink, amount, price, type_id, package_id )
                VALUES(?,?,?,?,?)";

        $values = [ "Zacskós tej", 10, 500, 3, 3 ];

        $success = DB::insert( $sql, $values );

        return $success;
    }

    public function updateDrink() {

        $sql = "UPDATE drinks SET drink = ? WHERE id = ?";
        $value = [ "Poharas tej", 48 ];

        $success = DB::update( $sql, $value );

        return $success;
    }

    public function deleteDrink() {

        $sql = "DELETE FROM drinks WHERE id = ?";

        $id = [ 48 ];

        $success = DB::delete( $sql, $id );

        return $success;
    }

    public function getAllData() {

        $sql = "SELECT drink, amount, price, type, package FROM drinks
                INNER JOIN types ON drinks.type_id = types.id
                INNER JOIN packages ON drinks.package_id = packages.id";

        $drinks = DB::select( $sql );

        return $drinks;
    }

    public function getDrinkData() {

        //36 id ital minden adata

        $sql = "SELECT drink, amount, price, type, package FROM drinks
                INNER JOIN types ON drinks.type_id = types.id
                INNER JOIN packages ON drinks.package_id = packages.id
                WHERE drinks.id = 36";

        $drink = DB::select( $sql );

        return $drink;
    }
}
