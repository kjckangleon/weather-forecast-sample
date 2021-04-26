<?php

namespace App\Http\Controllers;

use App\Exceptions\ForecastNotCreatedException;
use Illuminate\Http\Request;
use App\Http\Requests\ForecastRequest;
use App\Service\ForecastService;
use Exception;

class ForecastController extends Controller
{
    protected $forecastService;
    

    public function __construct(ForecastService $forecastService)
    {
        $this->forecastService = $forecastService;
        
    }

    public function index() {
        $response = [];
        try {
            $response = $this->forecastService->getAll();
        } catch (\Exception $e) {
            $response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }
        return response()->json($response, 200);
    }

    public function saveWeather(ForecastRequest $request) {
        $response = [];

        try {
            $formData = [
                'country' => $request->getCountry(),
                'city' => $request->getCity(),
                'weather_data' =>$request->getWeatherData()
            ];
           $response = $this->forecastService->create($formData);
        } catch (Exception $e) {
            $response = [
                'error' => $e->getMessage(),
                'code' => 500,
            ];
        }
        return response()->json($response, 200);
    }
}
