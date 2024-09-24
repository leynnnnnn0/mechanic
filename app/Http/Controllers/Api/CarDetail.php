<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Http;

class CarDetail extends Controller
{
    public static function getCarYears($make = '', $model = '')
    {
        try {
            $response = Http::get("https://carapi.app/api/years?make=$make&model=$model");
            $data = $response->json();
            return array_combine($data, $data);
        } catch (Exception $e) {
            return [];
        }
    }


    public static function getCarMakes()
    {
        try {
            $response = Http::get("https://carapi.app/api/makes");
            $data = array_map(function ($item) {
                return $item['name'];
            }, $response['data']);
            return array_combine($data, $data);
        } catch (Exception $e) {
            return [];
        }
    }
}
