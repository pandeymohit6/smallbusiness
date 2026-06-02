<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Enums\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SetupCountryDatabases extends Command
{
    protected $signature = 'country:setup-databases';

    protected $description = 'Create and migrate databases for all countries';

    public function handle(): int
    {
        $this->info('Setting up country-specific databases...');

        foreach (Country::all() as $country) {
            $this->setupCountryDatabase($country);
        }

        $this->info('✓ Country databases setup complete!');
        
        return self::SUCCESS;
    }

    protected function setupCountryDatabase(Country $country): void
    {
        $countryValue = $country->value;
        $dbName = "smallbusiness_{$countryValue}";
        $dbConnection = "mysql_{$countryValue}";

        $this->info("Setting up {$country->label()} database ({$dbName})...");

        try {
            // Create database if it doesn't exist
            $connection = DB::connection('mysql');
            $connection->statement("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
            $this->info("  ✓ Database created/exists");

            // Run migrations for this connection
            $this->call('migrate', [
                '--database' => $dbConnection,
                '--force' => true,
            ]);

            $this->info("  ✓ Migrations completed for {$country->label()}");
        } catch (\Exception $e) {
            $this->error("  ✗ Error setting up {$country->label()}: {$e->getMessage()}");
        }
    }
}
