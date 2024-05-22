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
        Schema::create('image_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained(table : 'rooms' , indexName : 'image_rooms_room_id') ;
            $table->string('image_room' , 255) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_rooms');
    }
};
