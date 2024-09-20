<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255', 'unique:locations,name,' . $this->location?->id],
            'latitude' => ['required', 'numeric', 'min:-90', 'max:90'],
            'longitude' => ['required', 'numeric', 'min:-180', 'max:180'],
            'marker_color' => ['required', 'hex_color'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
