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
        Schema::create('selections', function (Blueprint $table) {
            $table->id();
            $table->string('table');
            $table->string('field');
            $table->string('code');
            $table->string('name');
            $table->integer('order');
            $table->unique(['table','field', 'code'], 'selections_table_code_unique');
            $table->text('remark')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('selections');
    }
};
