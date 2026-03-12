<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEtudiantRequest;
use App\Http\Requests\UpdateEtudiantRequest;
use App\Http\Resources\EtudiantResource;
use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    // GET /api/v1/etudiants
    public function index(Request $request)
    {
        $query = Etudiant::query();

        // Recherche ?q=
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($builder) use ($q) {
                $builder->where('nom', 'like', "%$q%")
                        ->orWhere('prenom', 'like', "%$q%")
                        ->orWhere('email', 'like', "%$q%");
            });
        }

        // Include relation ?include=cours
        if ($request->include === 'cours') {
            $query->with('cours');
        }

        $perPage = $request->get('per_page', 10);
        $etudiants = $query->paginate($perPage);

        return EtudiantResource::collection($etudiants);
    }

    // POST /api/v1/etudiants
    public function store(StoreEtudiantRequest $request)
    {
        $etudiant = Etudiant::create($request->validated());
        return new EtudiantResource($etudiant);
        // 201 créé
    }

    // GET /api/v1/etudiants/{id}
    public function show(Request $request, Etudiant $etudiant)
    {
        if ($request->include === 'cours') {
            $etudiant->load('cours');
        }
        return new EtudiantResource($etudiant);
    }

    // PUT/PATCH /api/v1/etudiants/{id}
    public function update(UpdateEtudiantRequest $request, Etudiant $etudiant)
    {
        $etudiant->update($request->validated());
        return new EtudiantResource($etudiant);
    }

    // DELETE /api/v1/etudiants/{id}
    public function destroy(Etudiant $etudiant)
    {
        $etudiant->delete();
        return response()->noContent(); // 204
    }

    // POST /api/v1/etudiants/{id}/cours/attach
    public function attachCours(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'cours_ids'   => 'required|array',
            'cours_ids.*' => 'exists:cours,id',
        ]);

        $etudiant->cours()->attach($request->cours_ids);
        $etudiant->load('cours');

        return response()->json([
            'message' => 'Cours ajoutés avec succès',
            'data'    => new EtudiantResource($etudiant),
        ]);
    }

    // POST /api/v1/etudiants/{id}/cours/detach
    public function detachCours(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'cours_ids'   => 'required|array',
            'cours_ids.*' => 'exists:cours,id',
        ]);

        $etudiant->cours()->detach($request->cours_ids);
        $etudiant->load('cours');

        return response()->json([
            'message' => 'Cours retirés avec succès',
            'data'    => new EtudiantResource($etudiant),
        ]);
    }

    // POST /api/v1/etudiants/{id}/cours/sync
    public function syncCours(Request $request, Etudiant $etudiant)
    {
        $request->validate([
            'cours_ids'   => 'required|array',
            'cours_ids.*' => 'exists:cours,id',
        ]);

        $etudiant->cours()->sync($request->cours_ids);
        $etudiant->load('cours');

        return response()->json([
            'message' => 'Cours synchronisés avec succès',
            'data'    => new EtudiantResource($etudiant),
        ]);
    }
}
