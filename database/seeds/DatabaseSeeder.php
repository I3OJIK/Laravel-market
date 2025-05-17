<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Вставка данных для цветов
        $this->call(ColorTableSeeder::class);
        
        // Вставка данных для продуктов
        $this->call(ProductsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SubcategoriesTableSeeder::class);
        $this->call(ProductSubcategoryTableSeeder::class);

        // $this->call(UserSeeder::class);
    }
}
