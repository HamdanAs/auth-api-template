<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'ADM' => 'Admin',
            'PMSK' => 'Pemasok',
            'BLK' => 'Bulky',
            'RTL' => 'Retail',
            'WRG' => 'Warung',
            'PBL' => 'Pembeli'
        ];

        foreach($roles as $key => $role){
            Role::create([
                'code' => $key,
                'name' => $role
            ]);
        }
    }
}
