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
        Schema::create('persons', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('first_name')->nullable();
        $table->string('last_name')->nullable();
        $table->string('gender')->nullable();
        $table->string('street')->nullable();
        $table->string('number')->nullable();
        $table->string('city')->nullable();
        $table->string('zip')->nullable();
        $table->string('region')->nullable();
        $table->string('country')->nullable();
        $table->string('phone')->nullable();
        $table->text('remark')->nullable();
        $table->string('university_name')->nullable();
        $table->string('university_address')->nullable();
        $table->year('start_year')->nullable();
        $table->year('finish_year')->nullable();
        $table->string('student_id_picture_front')->nullable();
        $table->string('student_id_picture_back')->nullable();
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
        Schema::dropIfExists('persons');
    }
};
