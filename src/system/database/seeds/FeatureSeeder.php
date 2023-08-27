<?php

use Illuminate\Database\Seeder;

use App\Feature;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        Feature::create([
            'prefix' => 'vpn',
            'title' => 'VPN Account Creator',
            'description' => 'This feature allow Admin or Reseller create new VPN Account.',
            'status' => true
        ]);

        Feature::create([
            'prefix' => 'dns',
            'title' => 'DNS Record Creator',
            'description' => 'This feature allow Admin or Reseller create new DNS Record.',
            'status' => true
        ]);

        Feature::create([
            'prefix' => 'coupon',
            'title' => 'Coupon System',
            'description' => 'This feature allow Admin or Reseller to redeem coupon but only Admin can generate coupon.',
            'status' => true
        ]);

        Feature::create([
            'prefix' => 'reseller',
            'title' => 'Reseller System',
            'description' => 'This feature allow Reseller to Login, Admin To create new reseller & Reseller activities.',
            'status' => true
        ]);

        Feature::create([
            'prefix' => 'tickets',
            'title' => 'Ticketing System',
            'description' => 'This feature allow user support through Ticket.',
            'status' => true
        ]);

        Feature::create([
            'prefix' => 'register',
            'title' => 'Register System',
            'description' => 'This feature allow Registration on Panel',
            'status' => true
        ]);
    }
}
