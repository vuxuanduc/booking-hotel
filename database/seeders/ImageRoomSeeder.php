<?php

namespace Database\Seeders;

use App\Models\ImageRoom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ImageRoom::factory(500)->create() ;
    }
}
