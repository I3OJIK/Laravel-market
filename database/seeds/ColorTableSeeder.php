<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            ['name' => 'Красный', 'color_class' => 'bg-red-500'],
            ['name' => 'Синий', 'color_class' => 'bg-blue-500'],
            ['name' => 'Зеленый', 'color_class' => 'bg-green-500'],
            ['name' => 'Желтый', 'color_class' => 'bg-yellow-500'],
            ['name' => 'Оранжевый', 'color_class' => 'bg-orange-500'],
            ['name' => 'Фиолетовый', 'color_class' => 'bg-purple-500'],
            ['name' => 'Розовый', 'color_class' => 'bg-pink-500'],
            ['name' => 'Серый', 'color_class' => 'bg-gray-500'],
            ['name' => 'Черный', 'color_class' => 'bg-black'],
            ['name' => 'Белый', 'color_class' => 'bg-white'],
        ]);
    }
}
