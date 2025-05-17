<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategories')->insert([
            ['name' => 'Смартфоны', 'description' => 'ав', 'category_id' => '1'],
            ['name' => 'Телевизоры', 'description' => 'ав', 'category_id' => '1'],
            ['name' => 'Часы', 'description' => 'ав', 'category_id' => '1'],
            ['name' => 'Копьютеры и комплектующие', 'description' => 'ав', 'category_id' => '1'],
            ['name' => 'Колонки', 'description' => 'ав', 'category_id' => '1'],

            ['name' => 'Холодильники', 'description' => 'ав', 'category_id' => '2'],
            ['name' => 'Плиты', 'description' => 'ав', 'category_id' => '2'],
            ['name' => 'Морозильники', 'description' => 'ав', 'category_id' => '2'],
            ['name' => 'Вытяжки', 'description' => 'ав', 'category_id' => '2'],
            ['name' => 'Пылесосы', 'description' => 'ав', 'category_id' => '2'],

            ['name' => 'Футболки', 'description' => 'ав', 'category_id' => '3'],
            ['name' => 'Кросоовки', 'description' => 'ав', 'category_id' => '3'],
            ['name' => 'Шорты', 'description' => 'ав', 'category_id' => '3'],
            ['name' => 'Джемперы, свитеры', 'description' => 'ав', 'category_id' => '3'],
            ['name' => 'Куртки', 'description' => 'ав', 'category_id' => '3'],

            ['name' => 'Уход за волосами', 'description' => 'ав', 'category_id' => '4'],
            ['name' => 'Уход за лицом', 'description' => 'ав', 'category_id' => '4'],
            ['name' => 'Уход за телом', 'description' => 'ав', 'category_id' => '4'],
            ['name' => 'Дезодоранты', 'description' => 'ав', 'category_id' => '4'],
            ['name' => 'Кремы и масла', 'description' => 'ав', 'category_id' => '4'],

        ]);
    }
}
