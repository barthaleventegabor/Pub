<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Drink;
use App\Models\Type;
use App\Models\Package;
use App\Policies\DrinkPolicy;
use Laravel\Sanctum\Sanctum;

class DrinkPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_create_new_drink()
    {
        $user = User::factory()->create(["role" => "user"]);
        $type = Type::factory()->create(["type" => "TestType"]);
        $package = Package::factory()->create(["package" => "TestPackage"]);

        $drink = [
            "name" => "testDrink",
            "amount" => 100,
            "price" => 100,
            "type" =>$type,
            "package" => $package

        ];

        $respone = $this->actingAs($user, "sanctum")->postJson("/api/newdrink", $drink,[
            "Accept" => "application/json"
        ]);
        
        $respone->assertStatus(403);
        $this->assertDatabaseMissing("drinks", [
            "drink" => "testDrink",
        ]);
    }

    public function test_admin_create_new_drink_valid_token()
    {
        $user = User::factory()->create(["role" => "admin"]);
        Sanctum::actingAs($user, ["drinks:create"]);

        $policy = new DrinkPolicy();

        $respone = $policy->create($user);

        $this->assertTrue($respone->allowed());

    }

    public function test_admin_create_new_drink_invalid_token()
    {
        $user = User::factory()->create(["role" => "admin"]);
        Sanctum::actingAs($user, ["wrong:ability"]);

        $policy = new DrinkPolicy();

        $respone = $policy->create($user);

        $this->assertFalse($respone->allowed());

        $this->assertEquals("Nincs jogosultsága az adatfelvételhez", $respone->message());

    }
}

