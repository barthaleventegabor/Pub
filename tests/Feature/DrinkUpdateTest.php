<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Drink;
use App\Models\Type;
use App\Models\Package;
use Laravel\Sanctum\Sanctum;

class DrinkUpdateTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_update_drink()
    {
        $user = User::factory()->create(["role" => "user"]);

        $type = Type::factory()->create(["type" => "Sor"]);
        $package = Package::factory()->create(["package" => "Uveg"]);
        $drink = Drink::create([
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);

        $payload = [
            "drink" => "DAB2",
            "amount" => 20,
            "price" => 150,
            "type" => "Sor",
            "package" => "Uveg",
        ];

        $response = $this->actingAs($user, "sanctum")
            ->putJson("/api/updatedrink/{$drink->id}", $payload, [
                "Accept" => "application/json",
            ]);

        $response->assertForbidden();

        $this->assertDatabaseHas("drinks", [
            "id" => $drink->id,
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);
    }

    public function test_admin_can_update_drink_with_valid_token_ability()
    {
        $admin = User::factory()->create(["role" => "admin"]);
        Sanctum::actingAs($admin, ["drinks:update"]);

        $type = Type::factory()->create(["type" => "Sor"]);
        $package = Package::factory()->create(["package" => "Uveg"]);
        $drink = Drink::create([
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);

        $payload = [
            "drink" => "DAB2",
            "amount" => 20,
            "price" => 150,
            "type" => "Sor",
            "package" => "Uveg",
        ];

        $response = $this->actingAs($admin, "sanctum")
            ->putJson("/api/updatedrink/{$drink->id}", $payload, [
                "Accept" => "application/json",
            ]);

        $response->assertStatus(500);

        $this->assertDatabaseHas("drinks", [
            "id" => $drink->id,
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);
    }

    public function test_super_can_update_drink()
    {
        $super = User::factory()->create(["role" => "super"]);

        $type = Type::factory()->create(["type" => "Sor"]);
        $package = Package::factory()->create(["package" => "Uveg"]);
        $drink = Drink::create([
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);

        $payload = [
            "drink" => "DAB2",
            "amount" => 20,
            "price" => 150,
            "type" => "Sor",
            "package" => "Uveg",
        ];

        $response = $this->actingAs($super, "sanctum")
            ->putJson("/api/updatedrink/{$drink->id}", $payload, [
                "Accept" => "application/json",
            ]);

        $response->assertStatus(500);

        $this->assertDatabaseHas("drinks", [
            "id" => $drink->id,
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);
    }
}
