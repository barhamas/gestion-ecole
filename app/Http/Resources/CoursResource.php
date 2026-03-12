<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoursResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'             => $this->id,
            'libelle'        => $this->libelle,
            'professeur'     => $this->professeur,
            'volume_horaire' => $this->volume_horaire,
            'created_at'     => $this->created_at,
            // Inclure les étudiants seulement si chargés
            'etudiants'      => $this->whenLoaded('etudiants', fn() =>
                EtudiantResource::collection($this->etudiants)
            ),
        ];
    }
}
