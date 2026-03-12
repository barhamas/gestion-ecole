<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEtudiantRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'prenom'         => 'sometimes|string|max:100',
            'nom'            => 'sometimes|string|max:100',
            'email'          => 'sometimes|email|unique:etudiants,email,' . $this->route('etudiant'),
            'date_naissance' => 'sometimes|date',
        ];
    }
}
