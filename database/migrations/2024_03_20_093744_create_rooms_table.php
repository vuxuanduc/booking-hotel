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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')->constrained(table : 'hotels' , indexName : 'rooms_hotel_id') ;
            $table->foreignId('room_type_id')->constrained(table : 'room_types' , indexName : 'room_types_room_type_id') ;
            $table->string('room_name' , 200) ;
            $table->integer('number_people')->comment("Số người ở") ;
            $table->text('description')->comment("Mô tả phòng") ;
            $table->float('price') ;
            $table->enum('status' , [1 , 2])->default(1)->comment("Trạng thái phòng") ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
