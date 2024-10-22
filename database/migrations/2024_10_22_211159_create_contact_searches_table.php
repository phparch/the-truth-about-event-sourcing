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
        Schema::create('contact_searches', function (Blueprint $table) {
            $table->snowflakeId();
            $table->addColumn('string', 'first_name');
            $table->addColumn('string', 'last_name');
            $table->addColumn('string', 'folder');
            $table->snowflake('owner_id')->index();
            $table->foreign('owner_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_searches');
    }
};
