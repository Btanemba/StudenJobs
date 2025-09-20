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
        Schema::table('persons', function (Blueprint $table) {
            // Add valid_till as a date field (or datetime if you prefer)
            $table->date('valid_till')->nullable()->after('payment_plan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('persons', function (Blueprint $table) {
            $table->dropColumn('valid_till');
        });
    }
};
