<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Электроника'],
            ['name' => 'Бытовая техника'],
            ['name' => 'Одежда'],
            ['name' => 'Красота'],
        ]);
    }
}
