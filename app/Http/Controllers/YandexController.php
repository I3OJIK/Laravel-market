<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class YandexController extends Controller
{
    public function suggest(Request $request)
    {
        $text = $request->query('text');
        $apikey = '40e203c6-408e-4bb6-9cbc-275d9d67a54e';

        $url = 'https://suggest-maps.yandex.ru/v1/suggest';

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0',
        ])->get($url, [
            'apikey' => $apikey,
            'text' => $text
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Ошибка запроса к Yandex'], $response->status());
        }

        return $response->json();
    }

}
