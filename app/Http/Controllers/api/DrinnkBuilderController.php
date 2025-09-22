<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;  //mi importáltuk

class DrinnkBuilderController extends Controller
{
    public function getDrinks(){
        $drinks = DB::table("drinks")->get();

        return response()->json(["drinks" => $drinks]);
    }

    public function getSelectDrinks(){
        $drinks = DB::table("drinks")->select("drink as Ital","amount as Mennyiség")->get();
        return response()->json(["drinks" => $drinks]);
    }

    // public function getDrink(){
    //     $drink = DB::table( "drinks" )->where( "amount", "<", 300 )->select("drink as Ital", "amount as Mennyiség")->get(); //lekérdezi azokat az italokat (drinks táblabol) amelyikből kevesebb van mint 300

    //     return response()->json(["drink" => $drink]);
    // }

    

    public function getFoundDrink() {
        // $drink = DB::table("drinks")
        // ->where("amount", "<", 300)
        // ->where("drink", "like", "%li%") // itt szűrjük azokat, amikben benne van a 'li'
        // ->select("drink as Ital", "amount as Mennyiség")
        // ->first();  //get helyett azért írtuk, mert ez csak az elsőt kéri le
        $drink = DB::table("drinks")->whereLike("drink", "%li%")->get();
        return response()->json(["drink" => $drink]);
    }


    public function getDates(){
        $date=DB::table("types")->whereDate("created","2023-05-20")->get();
        $year = DB::table("types")->whereYear("created","2020")->get();
        //így ugye a year-t adja vissza
        return response()->json(["date" => $year]);
    }
}
