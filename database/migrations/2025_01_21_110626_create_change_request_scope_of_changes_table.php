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
        Schema::create('change_request_scope_of_changes', function (Blueprint $table) {
            $table->id();
            $table->foreignId("change_request_id")->constrained("change_requests");
            $table->foreignId("scope_of_change_id")->constrained("scope_of_changes");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_request_scope_of_changes');
    }
};
