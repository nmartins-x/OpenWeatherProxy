<?php

namespace App\Http\Request;

use \Illuminate\Foundation\Http\FormRequest;

class ShowWeatherRequest extends FormRequest {
    /**
     * @return array
     */
    public function rules(): array
    {
        // Either city or country query parameters should be passed
        return [
            'city' => 'required_without:country',
            'country' => 'required_without:city',
        ];
    }
}
