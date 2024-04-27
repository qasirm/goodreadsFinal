<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('friendships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // references 'id' on 'users' table
            $table->foreignId('friend_id')->constrained('users')->onDelete('cascade'); // references 'id' on 'users' table
            $table->boolean('is_confirmed')->default(false); // to manage friend requests
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('friendships');
    }
};

