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
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name_hotel' , 200) ;
            $table->text('address' , 400) ;
            $table->string('phone' , 40) ;
            $table->string('email' , 100) ;
            $table->integer('number_views')->default(0) ;
            $table->enum('status' , [1 , 2])->default(1)->comment("Ẩn/hiện khách sạn") ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
