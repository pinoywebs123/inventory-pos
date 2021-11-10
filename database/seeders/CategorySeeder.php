<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name'=> 'Nabubulok']);
        Category::create(['name'=> 'Hindi Nabubulok']);
        Category::create(['name'=> 'Walang Kwenta']);
        Category::create(['name'=> 'Walang Forever']);
    }
}
