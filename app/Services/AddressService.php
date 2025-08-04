<?php

namespace App\Services;

use App\Models\Address;
use App\Models\CartItem;
use App\Models\ColorProduct;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AddressService
{
    protected string $url = 'https://suggest-maps.yandex.ru/v1/suggest';
    protected string $apiKey;

    //подключение ключа для апи яндекс геосаджест
    public function __construct()
    {
        $this->apiKey = env('YANDEX_SUGGEST_KEY');
    }

    
    /**
     * Предлагает варианты адреса на основе введённой строки.
     *
     * Выполняет HTTP-запрос к внешнему API и возвращает коллекцию 
     * отформатированных результатов с ключами `title` и `subtitle`.
     *
     * @param string $query Строка, по которой подбираются варианты адресов
     * @return Collection Коллекция с результатами подсказки
     */
    public function getSuggestions(string $query)
    {

        $response = Http::get($this->url, [
            'apikey' => $this->apiKey,
            'text' => $query
        ]);
        //если запрос вернул ошибку то возвращаем пустую коллекцию
        if (! $response->successful()) {
            return collect();
        }

        $results = collect($response->json()['results'] ?? []);

        // Очищаем и форматируем
        return $results->map(fn($item) => [
            'title'    => data_get($item, 'title.text', ''),
            'subtitle' => data_get($item, 'subtitle.text', ''),
        ]);
    }

    public function save(int $userId, array $data)
    {
        return Address::create(array_merge($data, ['user_id' => $userId]));
    }
}
