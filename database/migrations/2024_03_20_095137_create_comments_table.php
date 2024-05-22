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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained(table : 'users' , indexName : 'comments_user_id') ;
            $table->foreignId('hotel_id')->constrained(table : 'hotels' , indexName : 'comments_hotel_id') ;
            $table->string('content_comment' , 250)->comment("Nội dung bình luận") ;
            $table->date('date_comment')->comment("Ngày bình luận") ;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
