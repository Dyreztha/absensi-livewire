<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkLocation;

class WorkLocationSeeder extends Seeder
{

public function run(): void
{
    WorkLocation::updateOrCreate(
        ['id' => 1],
        [
            'name' => 'Kantor',
            'lat' => -6.570585,
            'lng' => 106.689110,
            'radius_meters' => 200,
            'active' => true,
        ]
    );
}

}
