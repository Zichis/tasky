<?php

namespace Database\Seeders;

use App\Models\Organization;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organization = Organization::firstOrCreate([
            'name' => 'Rosabon Financial Services',
            'slug' => Str::slug('Rosabon Financial Services'),
            'email' => 'info@rosabon-finance.com',
            'address' => '32 Montgomery Street, Yaba, Lagos',
            'brief_info' => 'No information available',
            'super_admin_id' => 1
        ]);

        $user = User::first();

        $organization->users()->sync($user);
    }
}
