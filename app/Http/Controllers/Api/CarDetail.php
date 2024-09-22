<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class CarDetail extends Controller
{
    public static function getCarYears($make = '', $model = '')
    {
        $response = Http::get("https://carapi.app/api/years?make=$make&model=$model");
        if ($response->successful()) {
            $data = $response->json();
            return array_combine($data, $data);
        }
        return [];
    }

    public static function getCarMakes()
    {
        $response = Http::get("https://carapi.app/api/makes");
        if ($response->successful()) {
            $data = array_map(function ($item) {
                return $item['name'];
            }, $response['data']);
            return array_combine($data, $data);
        }
        return [];
    }
}
