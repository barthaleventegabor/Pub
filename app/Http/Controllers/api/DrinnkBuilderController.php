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
        $month = DB::table("types")->whereMonth("created","10")->get();
        $day = DB::table("types")->whereDay("created","26")->get();
        
        return response()->json(["year" => $year,"month"=>$month,"day"=>$day]);
    }

    // public function getPalinka(){
    //     $palinkas = DB::table("drinks")->groupBy("type_id")->having("type_id","=","5")->get();
    //     return response()->json(["palinkas" => $palinkas]);
    // }   ez nemjó

    public function getAllData(){
        $data = DB::table( "drinks" )->select("drink", "type", "package")
        ->join("types", "drinks.type_id", "=", "types.id")
        ->join("packages", "drinks.package_id", "=" ,"packages.id")
        ->get();
        return response()->json(["data" => $data]);

    }

    public function addDrink(){
        $id = DB::table("drinks")->insertGetId([
            "drink" => "Bubis víz",
            "amount" => 10,
            "price" => 300,
            "type_id"=>13,
            "package_id" =>4
        ]);
        return response()->json(["id" => $id]);
    }

    public function updateDrink(){
        $success = DB::table("drinks")->where("id","50")->update([
            "drink" => "Tekkila"
        ]);
        return response()->json(["succes"=>$success]);
    }

    public function modifyDrink(){
        $success = DB::table("drinks")->updateOrInsert(
            ["id"=>52],
            ["drink"=>"Sima víz","amount"=>15,"price"=>200,"type_id" =>6,"package_id"=> 7]
        
        );
       return response()->json(["success" => $success]);

    }

    public function deleteDrinks($id){
        // $success = DB::table("drinks")->where("id",$id)->delete();  ez akkor lenne ha csak egy drinket akarnék törölni

        $success = DB::table("drinks")->truncate();

        return response()->json(["success" => $success]);
    }
}
