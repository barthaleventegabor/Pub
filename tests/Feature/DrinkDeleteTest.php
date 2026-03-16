<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Drink;
use App\Models\Type;
use App\Models\Package;
use Laravel\Sanctum\Sanctum;

class DrinkDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_cannot_delete_drink()
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

        $this->actingAs($user);

        $response = $this->actingAs($user, "sanctum")
            ->deleteJson("/api/deletedrink/{$drink->id}", [], [
                "Accept" => "application/json",
            ]);

        $response->assertForbidden();
        $this->assertDatabaseHas("drinks", ["id" => $drink->id]);
    }

    public function test_admin_can_delete_drink_with_valid_token_ability()
    {
        $admin = User::factory()->create(["role" => "admin"]);
        $this->actingAs($admin);

        $type = Type::factory()->create(["type" => "Sor"]);
        $package = Package::factory()->create(["package" => "Uveg"]);
        $drink = Drink::create([
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);

        Sanctum::actingAs($admin, ["drinks:delete"]);

        $response = $this->actingAs($admin, "sanctum")
            ->deleteJson("/api/deletedrink/{$drink->id}", [], [
                "Accept" => "application/json",
            ]);

        $response->assertOk();
        $this->assertDatabaseMissing("drinks", ["id" => $drink->id]);
    }

    public function test_super_can_delete_drink_with_valid_token_ability()
    {
        $super = User::factory()->create(["role" => "super"]);
        $this->actingAs($super);

        $type = Type::factory()->create(["type" => "Sor"]);
        $package = Package::factory()->create(["package" => "Uveg"]);
        $drink = Drink::create([
            "drink" => "DAB",
            "amount" => 10,
            "price" => 100,
            "type_id" => $type->id,
            "package_id" => $package->id,
        ]);

        Sanctum::actingAs($super, ["drinks:delete"]);

        $response = $this->actingAs($super, "sanctum")
            ->deleteJson("/api/deletedrink/{$drink->id}", [], [
                "Accept" => "application/json",
            ]);

        $response->assertOk();
        $this->assertDatabaseMissing("drinks", ["id" => $drink->id]);
    }
}
