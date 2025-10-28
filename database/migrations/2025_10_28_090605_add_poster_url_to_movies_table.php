<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Add this line
            $table->string('poster_url', 500)->nullable()->after('review_content');
        });
    }
    public function down(): void
    {
        Schema::table('movies', function (Blueprint $table) {
            // Add this line
            $table->dropColumn('poster_url');
        });
    }
};
