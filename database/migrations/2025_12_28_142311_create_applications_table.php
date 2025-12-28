<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applications', function (Illuminate\Database\Schema\Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('admission_session_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('draft'); // draft, submitted, under_review, waitlisted, offered, rejected, admitted
            $table->decimal('merit_score', 8, 2)->nullable();
            $table->foreignId('assigned_subject_id')->nullable()->constrained('subjects')->nullOnDelete();

            // Personal Info
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();

            // SSC Info
            $table->string('ssc_board')->nullable();
            $table->string('ssc_roll')->nullable();
            $table->string('ssc_reg')->nullable();
            $table->year('ssc_year')->nullable();
            $table->decimal('ssc_gpa', 3, 2)->nullable();

            // HSC Info
            $table->string('hsc_board')->nullable();
            $table->string('hsc_roll')->nullable();
            $table->string('hsc_reg')->nullable();
            $table->year('hsc_year')->nullable();
            $table->decimal('hsc_gpa', 3, 2)->nullable();
            $table->string('hsc_group')->nullable(); // Science, Arts, Commerce

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
