<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkillsTable extends Migration
{
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('skill_name');
            $table->integer('years_of_experience')->default(0);
            $table->decimal('price', 8, 2)->nullable();
            $table->text('description')->nullable();
            $table->string('skill_level')->nullable();
            $table->string('certification')->nullable();
            $table->json('sample_pictures')->nullable();
            $table->json('sample_videos')->nullable();   
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('skills');
    }
}
