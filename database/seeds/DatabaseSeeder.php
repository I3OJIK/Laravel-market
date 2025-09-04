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
        $this->call(UserTableSeeder::class);
        // Вставка данных для цветов
        $this->call(ColorTableSeeder::class);
        
        // Вставка данных для продуктов
        $this->call(CategoriesTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(SubcategoriesTableSeeder::class);
        $this->call(ProductSubcategoryTableSeeder::class);

    }
}
