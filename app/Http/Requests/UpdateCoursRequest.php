<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCoursRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'libelle'        => 'sometimes|string|max:200',
            'professeur'     => 'sometimes|string|max:100',
            'volume_horaire' => 'sometimes|integer|min:1',
        ];
    }
}
