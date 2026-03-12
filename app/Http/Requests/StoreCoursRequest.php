<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoursRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'libelle'        => 'required|string|max:200',
            'professeur'     => 'required|string|max:100',
            'volume_horaire' => 'required|integer|min:1',
        ];
    }
}
