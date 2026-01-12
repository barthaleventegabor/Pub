<?php

namespace App\Services;

class AbilityService {
    /**
     * Create a new class instance.
     */
    public function __construct() {
        //
    }

    public function createAdminAbilities() {


        return [
            "admin",
            "users:create",
            "users:read",
            "users:update",
            "users:delete",
            "drinks:create",
            "drinks:read",
            "drinks:update",
            "packages:create",
            "packages:read",
            "packages:update",
            "types:create",
            "types:read",
            "types:update",
            "user_profiles:create",
            "user_profiles:update",
            "user_profiles:read",
            "user_profiles:delete"
        ];
    }

    public function createUserAbilities() {

        return [
            "user",
            "users:create",
            "users:update",
            "users:delete",
            "user_profiles:create",
            "user_profiles:update",
            "user_profiles:read",
            "user_profiles:delete"
        ];
    }
}
