<?php

namespace Database\Seeders;

use App\Models\ReferralType;
use Illuminate\Database\Seeder;

class ReferralTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ReferralType::create([
            'type_name' => 'Partner',
            'type_description' => 'Partner',
        ]);

        ReferralType::create([
            'type_name' => 'facebook',
            'type_description' => 'facebook',
        ]);

        ReferralType::create([
            'type_name' => 'google',
            'type_description' => 'google',
        ]);

        ReferralType::create([
            'type_name' => 'instagram',
            'type_description' => 'instagram',
        ]);
    }
}
