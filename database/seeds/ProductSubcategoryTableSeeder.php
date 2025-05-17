<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Получаем все ID
         $productIds = DB::table('products')->pluck('id')->toArray();
         $subcategoryIds = DB::table('subcategories')->pluck('id')->toArray();
 
         $pivotData = [];
 
         // Допустим, каждый продукт будет иметь от 1 до 3 подкатегорий
         foreach ($productIds as $productId) {
             $randomSubcategories = collect($subcategoryIds)->random(rand(1, 2))->unique();
 
             foreach ($randomSubcategories as $subcategoryId) {
                 $pivotData[] = [
                     'product_id' => $productId,
                     'subcategory_id' => $subcategoryId,
                 ];
             }
         }
 
         // Вставляем в пивот-таблицу
         DB::table('product_subcategory')->insert($pivotData);
     
    }
}
