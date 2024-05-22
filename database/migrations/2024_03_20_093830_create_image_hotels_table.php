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
        Schema::create('image_hotels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained(table : 'hotels' , indexName : 'image_hotels_hotel_id') ;
            $table->string('image_hotel' , 255) ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_hotels');
    }
};
