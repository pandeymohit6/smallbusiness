<?php

namespace Database\Seeders;

use App\Models\BuyerExperience;
use App\Models\BuyerType;
use App\Models\Country;
use Illuminate\Database\Seeder;

class BuyerRegistrationSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // Seed Buyer Types
        $buyerTypes = [
            ['name' => 'Private Buyer - First Time', 'description' => 'First-time individual buyer', 'sort_order' => 1],
            ['name' => 'Private Buyer - Experienced', 'description' => 'Experienced individual buyer', 'sort_order' => 2],
            ['name' => 'Corporate Buyer', 'description' => 'Corporate entity buyer', 'sort_order' => 3],
            ['name' => 'Intermediary', 'description' => 'Intermediary/broker', 'sort_order' => 4],
            ['name' => 'Family Office', 'description' => 'Family office investor', 'sort_order' => 5],
            ['name' => 'Agent or Broker', 'description' => 'Agent or broker', 'sort_order' => 6],
            ['name' => 'Private Equity or VC', 'description' => 'Private equity or venture capital', 'sort_order' => 7],
            ['name' => 'Searcher or Search Fund', 'description' => 'Search fund operator', 'sort_order' => 8],
            ['name' => 'Other', 'description' => 'Other buyer type', 'sort_order' => 9],
        ];

        foreach ($buyerTypes as $type) {
            BuyerType::firstOrCreate(
                ['name' => $type['name']],
                ['description' => $type['description'], 'sort_order' => $type['sort_order'], 'is_active' => true]
            );
        }

        // Seed Buyer Experiences
        $buyerExperiences = [
            ['name' => 'Never bought businesses', 'description' => 'No previous business purchase experience', 'sort_order' => 1],
            ['name' => 'Bought up to 5 businesses', 'description' => 'Experience with up to 5 business purchases', 'sort_order' => 2],
            ['name' => 'Bought more than 5 businesses', 'description' => 'Experience with more than 5 business purchases', 'sort_order' => 3],
        ];

        foreach ($buyerExperiences as $experience) {
            BuyerExperience::firstOrCreate(
                ['name' => $experience['name']],
                ['description' => $experience['description'], 'sort_order' => $experience['sort_order'], 'is_active' => true]
            );
        }

        // Seed Countries
        $countries = [
            ['name' => 'United States', 'code' => 'US', 'phone_code' => '+1', 'sort_order' => 1],
            ['name' => 'United Kingdom', 'code' => 'GB', 'phone_code' => '+44', 'sort_order' => 2],
            ['name' => 'Australia', 'code' => 'AU', 'phone_code' => '+61', 'sort_order' => 3],
            ['name' => 'Canada', 'code' => 'CA', 'phone_code' => '+1', 'sort_order' => 4],
            ['name' => 'India', 'code' => 'IN', 'phone_code' => '+91', 'sort_order' => 5],
            ['name' => 'Germany', 'code' => 'DE', 'phone_code' => '+49', 'sort_order' => 6],
            ['name' => 'France', 'code' => 'FR', 'phone_code' => '+33', 'sort_order' => 7],
            ['name' => 'Japan', 'code' => 'JP', 'phone_code' => '+81', 'sort_order' => 8],
            ['name' => 'Singapore', 'code' => 'SG', 'phone_code' => '+65', 'sort_order' => 9],
            ['name' => 'Hong Kong', 'code' => 'HK', 'phone_code' => '+852', 'sort_order' => 10],
        ];

        foreach ($countries as $country) {
            Country::firstOrCreate(
                ['name' => $country['name']],
                ['code' => $country['code'], 'phone_code' => $country['phone_code'], 'sort_order' => $country['sort_order'], 'is_active' => true]
            );
        }
    }
}
