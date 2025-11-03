<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->integer( "role" )->after( "password" )->default( 3 );
            $table->integer( "counter" )->after( "role" )->default( 0 );
            $table->integer( "status" )->after( "counter" )->default( 1 );
            $table->timestamp( "banning" )->after( "status" )->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
