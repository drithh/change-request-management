<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('change_requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('department_id')->constrained('departments');

            $table->string('status');
            $table->string('status_url');

            $table->text('change_request');
            $table->string('change_request_url');

            $table->text('reason');
            $table->string('support_document_url');

            $table->string('source_of_risk');
            $table->string('impact_of_risk');

            $table->enum('risk_evaluation_criteria_severity', ['minor', 'major', 'critical'])->default('minor');
            $table->string('causes_of_risk');
            $table->enum('risk_evaluation_criteria_probability', ['rare', 'possible', 'frequent'])->default('rare');
            $table->string('control_that_has_been_implemented');

            $table->enum('risk_evaluation_criteria_detectability', ['high', 'medium', 'low'])->default('high');
            $table->integer('risk_priority_number');

            $table->foreignId("facility_change_authorization_id")->constrained("facility_change_authorizations");
            $table->foreignId("regulatory_assesment_id")->constrained("regulatory_assesments");
            $table->foreignId("halal_assesment_id")->constrained("halal_assesments");

            $table->string('third_party_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_requests');
    }
};
