<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'AYM' => 'Ayam Beku',
            'TEH' => 'Teh',
            'IKN' => 'Ikan Segar',
            'SYR' => 'Sayuran',
            'BUH' => 'Buah-Buahan',
        ];

        foreach($categories as $key => $category){
            Category::create([
                'code' => $key,
                'name' => $category
            ]);
        }
    }
}
