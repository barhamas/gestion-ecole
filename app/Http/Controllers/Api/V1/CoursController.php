<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoursRequest;
use App\Http\Requests\UpdateCoursRequest;
use App\Http\Resources\CoursResource;
use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    // GET /api/v1/cours
    public function index(Request $request)
    {
        $query = Cours::query();

        // Filtre ?professeur=
        if ($request->filled('professeur')) {
            $query->where('professeur', 'like', '%' . $request->professeur . '%');
        }

        // Include ?include=etudiants
        if ($request->include === 'etudiants') {
            $query->with('etudiants');
        }

        $perPage = $request->get('per_page', 10);
        $cours = $query->paginate($perPage);

        return CoursResource::collection($cours);
    }

    // POST /api/v1/cours
    public function store(StoreCoursRequest $request)
    {
        $cours = Cours::create($request->validated());
        return (new CoursResource($cours))->response()->setStatusCode(201);
    }

    // GET /api/v1/cours/{id}
    public function show(Request $request, Cours $cours)
    {
        if ($request->include === 'etudiants') {
            $cours->load('etudiants');
        }
        return new CoursResource($cours);
    }

    // PUT/PATCH /api/v1/cours/{id}
    public function update(UpdateCoursRequest $request, Cours $cours)
    {
        $cours->update($request->validated());
        return new CoursResource($cours);
    }

    // DELETE /api/v1/cours/{id}
    public function destroy(Cours $cours)
    {
        $cours->delete();
        return response()->noContent(); // 204
    }
}
