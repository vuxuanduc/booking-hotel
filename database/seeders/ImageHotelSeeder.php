<?php

namespace Database\Seeders;

use App\Models\ImageHotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageHotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImageHotel::factory(100)->create() ;
    }
}
