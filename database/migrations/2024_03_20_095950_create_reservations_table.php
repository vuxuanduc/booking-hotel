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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(table : 'users' , indexName : 'reservations_user_id') ;
            $table->foreignId('room_id')->constrained(table : 'rooms' , indexName : 'reservations_room_id') ;
            $table->foreignId('status_id')->constrained(table : 'statuses' , indexName : 'reservations_status_id') ;
            $table->datetime('reservation_date')->comment("Thời gian đặt phòng") ;
            $table->date('check_in_date')->comment("Ngày đến") ;
            $table->date('check_out_date')->comment("Ngày đi") ;
            $table->float('price') ;
            $table->float('total_amount') ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
