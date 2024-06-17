<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['service_name' => 'terabox'],
            ['service_name' => 'streamtape'],
            ['service_name' => 'doodstream'],
        ];

        DB::table('services')->insert($services);
    }
}
