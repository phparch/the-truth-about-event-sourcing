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
        Schema::create('contact_data_store', function (Blueprint $table) {
            $table->id();
            $table->uuid('event_id');
            $table->string('aggregate_root_id');
            $table->unsignedBigInteger('version')->nullable();
            $table->json('payload');
            $table->timestamps();
            $table->index(['aggregate_root_id', 'version']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_data_store');
    }
};
