<?php

namespace Database\Seeders;

use App\Models\Referral;
use Illuminate\Database\Seeder;

class ReferralSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Referral::create([
            'user_id' => 1,
            'referral_type_id' => 1,
            'referral_code' => 'YAGSTTDG',
            'referral_description' => 'YAGSTTDG',
        ]);

        Referral::create([
            'user_id' => 2,
            'referral_type_id' => 2,
            'referral_code' => 'YAG567STTDG',
            'referral_description' => 'YAGSTT212DG',
        ]);

        Referral::create([
            'user_id' => 3,
            'referral_type_id' => 3,
            'referral_code' => 'U6DHJGHG ',
            'referral_description' => 'U6DHJGHG',
        ]);

        Referral::create([
            'user_id' => 4,
            'referral_type_id' => 4,
            'referral_code' => 'QWEFOIHFOQIH ',
            'referral_description' => 'QWEFOIHFOQIH',
        ]);
    }
}
