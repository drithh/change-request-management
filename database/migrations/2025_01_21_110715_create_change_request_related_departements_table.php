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
        Schema::create('change_request_related_departements', function (Blueprint $table) {
            $table->id();
            $table->foreignId("change_request_id")->constrained("change_requests");
            $table->foreignId("related_departement_id")->constrained("related_departements");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_request_related_departements');
    }
};
