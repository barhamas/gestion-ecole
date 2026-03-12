<?php

namespace Tests\Feature;

use App\Models\Cours;
use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EtudiantTest extends TestCase
{
    use RefreshDatabase;

    private function getToken(): string
    {
        $user = User::factory()->create();
        return $user->createToken('test')->plainTextToken;
    }

    /** ── 401 sans token ── */
    public function test_liste_etudiants_sans_token_retourne_401()
    {
        $response = $this->getJson('/api/v1/etudiants');
        $response->assertStatus(401);
    }

    /** ── Création 201 ── */
    public function test_creation_etudiant_retourne_201()
    {
        $token = $this->getToken();

        $response = $this->withToken($token)->postJson('/api/v1/etudiants', [
            'prenom'         => 'Fatou',
            'nom'            => 'Diallo',
            'email'          => 'fatou@test.com',
            'date_naissance' => '2000-05-15',
        ]);

        $response->assertStatus(201)
                 ->assertJsonPath('data.email', 'fatou@test.com');
    }

    /** ── Attach cours ── */
    public function test_attach_cours_retourne_200()
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();
        $cours    = Cours::factory()->count(2)->create();

        $response = $this->withToken($token)->postJson(
            "/api/v1/etudiants/{$etudiant->id}/cours/attach",
            ['cours_ids' => $cours->pluck('id')->toArray()]
        );

        $response->assertStatus(200)
                 ->assertJsonPath('message', 'Cours ajoutés avec succès');
    }

    /** ── Sync cours ── */
    public function test_sync_cours_retourne_200()
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();
        $cours    = Cours::factory()->count(3)->create();

        $response = $this->withToken($token)->postJson(
            "/api/v1/etudiants/{$etudiant->id}/cours/sync",
            ['cours_ids' => $cours->pluck('id')->toArray()]
        );

        $response->assertStatus(200);
    }

    /** ── Delete 204 ── */
    public function test_suppression_etudiant_retourne_204()
    {
        $token    = $this->getToken();
        $etudiant = Etudiant::factory()->create();

        $response = $this->withToken($token)->deleteJson("/api/v1/etudiants/{$etudiant->id}");
        $response->assertStatus(204);
    }
}
