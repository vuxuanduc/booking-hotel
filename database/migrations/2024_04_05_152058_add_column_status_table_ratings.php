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
        Schema::table('ratings' , function(Blueprint $table){
            $table->enum('status' , [1 , 2])->default(1)->after('content_rating') ;
        }) ;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
