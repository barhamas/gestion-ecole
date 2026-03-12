<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EtudiantResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'prenom'         => $this->prenom,
            'nom'            => $this->nom,
            'email'          => $this->email,
            'date_naissance' => $this->date_naissance,
            'created_at'     => $this->created_at,
            // Inclure les cours seulement si chargés (include=cours)
            'cours'          => $this->whenLoaded('cours', fn() =>
                CoursResource::collection($this->cours)
            ),
        ];
    }
}
