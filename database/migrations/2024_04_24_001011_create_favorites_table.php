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
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('book_id');
            $table->foreign('book_id')->references('id')->on('books')->onDelete('cascade');  // Correct way to add a foreign key constraint on a string column
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['book_id']);
        });
        Schema::dropIfExists('favorites');
    }
};
