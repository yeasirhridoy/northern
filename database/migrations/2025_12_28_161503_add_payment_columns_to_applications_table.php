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
        Schema::table('applications', function (Blueprint $table) {
            $table->string('payment_method')->nullable()->after('status');
            $table->decimal('payment_amount', 10, 2)->nullable()->after('payment_method');
            $table->string('payment_trx_id')->nullable()->after('payment_amount');
            $table->string('payment_status')->nullable()->after('payment_trx_id'); // pending, approved, rejected
            $table->string('registration_id')->nullable()->unique()->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('applications', function (Blueprint $table) {
            //
        });
    }
};
