<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForecastRequest extends FormRequest
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
            'country' => ['required'],
            'city' => ['required'],
            'weather_data' => ['required'],
            
        ];
    }

    public function getCountry()
    {
        return $this->input('country', null);
    }

    public function getCity()
    {
        return $this->input('city', null);
    }

    public function getWeatherData()
    {
        return $this->input('weather_data', null);
    }
}
