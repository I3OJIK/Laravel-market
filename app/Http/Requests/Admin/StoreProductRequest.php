<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'               => 'required|string|max:255',
            'description'        => 'required|string',
            'price'              => 'required|numeric|min:0',
            'categoryId'         => 'required|exists:categories,id',
            'subcategoryIds'     => 'required|array',
            'subcategoryIds.*'   => 'required|exists:subcategories,id',
            'image'              => 'required|image|', 
            'colorStocks'        => 'array',
            'colorStocks.*'      => 'nullable|min:0',
        ];
    }

    public function messages()
    {
        return [
            'name.required'             => 'Введите название товара.',
            'name.string'               => 'Название должно быть строкой.',
            'name.max'                  => 'Название не должно превышать 255 символов.',

            'description.required'      => 'Введите описание товара.',
            'description.string'        => 'Описание должно быть строкой.',

            'price.required'            => 'Укажите цену товара.',
            'price.numeric'             => 'Цена должна быть числом.',
            'price.min'                 => 'Цена не может быть меньше 0.',

            'categoryId.required'       => 'Выберите категорию.',
            'categoryId.exists'         => 'Выбранная категория не найдена.',

            'subcategoryIds.required'   => 'Выберите хотя бы одну подкатегорию.',
            'subcategoryIds.array'      => 'Подкатегории должны быть в виде массива.',
            'subcategoryIds.*.exists'   => 'Выбранная подкатегория не найдена.',

            'image.required'            => 'Загрузите изображение товара.',
            'image.image'               => 'Файл должен быть изображением.',
            'image.max'                 => 'Размер изображения не должен превышать 4 МБ.',

            'colorStocks.array'         => 'Остатки по цветам должны быть массивом.',
            'colorStocks.*.integer'     => 'Остаток должен быть целым числом.',
            'colorStocks.*.min'         => 'Остаток не может быть меньше 0.',
        ];
    }
}
