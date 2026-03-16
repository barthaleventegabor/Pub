<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Drink;
use App\Models\Package;
use App\Models\Type;

class DrinkCreateTest extends TestCase {
    
    use RefreshDatabase;

    public function test_admin_creates_drink_successfully() {

        $user = User::factory()->create([ "role" => "admin" ]);
        $this->actingAs( $user );

        $type = Type::factory()->create([ "type" => "Sör" ]);
        $package = Package::factory()->create([ "package" => "Üveg" ]);

        $drink = [
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type" => "Sör",
            "package" => "Üveg"
        ];

        $response = $this->postJson( "api/newdrink", $drink );
        if( $response->status() === 422 ) {

            dump( $response->json() );
        }

        $response->assertOK();

        $this->assertDatabaseHas( "drinks", [

            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id
        ]);
    }

    public function test_user_creates_drink_fails() {

        $this->withoutExceptionHandling();
        //$this->withoutMiddleware();

        $user = User::factory()->create([ "role" => "user" ]);
        $type = Type::factory()->create([ "type" => "Sör" ]);
        $package = Package::factory()->create([ "package" => "Üveg" ]);

        $drink = [
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type" => "Sör",
            "package" => "Üveg"
        ];

        $response = $this->actingAs( $user, "sanctum" )
                    ->postJson( "/api/newdrink", $drink,  [ "Accept" => "application/json" ] );

        //dd( $response->json() );
        $response->assertForbidden(); 
        $this->assertDatabaseMissing( "drinks",
            [ "drink" => "DAB" ]
        );
    }
}
