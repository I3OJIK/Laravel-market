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
        
         // Получаем продукты с их category_id
        $products = DB::table('products')->select('id', 'category_id')->get();
        
 
         $pivotData = [];
 
         // Допустим, каждый продукт будет иметь от 1 до 3 подкатегорий
         foreach ($products as $product) {
            $categoryId = $product->category_id;
            $subcategories = DB::table('subcategories')->select('id', 'category_id')->where('category_id', $categoryId)->get();

             $randomSubcategories = collect($subcategories)->random(rand(1, 2))->unique();
 
             foreach ($randomSubcategories as $subcategory) {
                 $pivotData[] = [
                     'product_id' => $product->id,
                     'subcategory_id' => $subcategory->id,
                 ];
             }
         }
 
         // Вставляем в пивот-таблицу
         DB::table('product_subcategory')->insert($pivotData);
     
    }
}
