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
    Schema::create('movies', function (Blueprint $table) {
        $table->id();
        $table->string('title', 191);
        $table->tinyInteger('star_rating'); // Perfect for 1-5
        $table->text('review_content');
        $table->timestamps(); // Creates 'created_at' and 'updated_at'
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
