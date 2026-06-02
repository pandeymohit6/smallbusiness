<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\CountryModel;
use Illuminate\Database\Seeder;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        CountryModel::seedDefaults();
        
        $this->command->info('Countries seeded successfully!');
    }
}
