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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained(table : 'reservations' , indexName : 'ratings_reservation_id') ;
            $table->integer('rating') ;
            $table->string('content_rating' , 250)->comment("Nội dung đánh giá") ;
            $table->date('date_rating')->comment("Thời gian đánh giá") ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
