<?php

namespace Tests\Feature;

use App\Models\Output;
use App\Models\Prodi;
use App\Models\Research;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicResearcherTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_researcher_profile_page(): void
    {
        $response = $this->get(route('profil.peneliti'));

        $response->assertStatus(200);
        $response->assertSee('Direktori Dosen & Peneliti PKTJ');
        $response->assertSee('Dr. Ir. Hendro Wibowo, M.T.');
        $response->assertSee('Prof. Dr. Ir. Bambang Suhardi, M.Sc.');
    }

    public function test_researcher_directory_displays_research_and_publication_data(): void
    {
        $response = $this->get(route('profil.peneliti'));

        $response->assertStatus(200);
        // Hendro has research and output
        $response->assertSee('Sensor Deteksi Kelelahan');
        $response->assertSee('Driver Drowsiness Detection System');
    }

    public function test_filter_by_prodi_functions_correctly(): void
    {
        // Filter prodi TRO
        $responseTro = $this->get(route('profil.peneliti', ['prodi' => 'tro']));
        $responseTro->assertStatus(200);
        $responseTro->assertSee('Dr. Ir. Hendro Wibowo, M.T.');
        $responseTro->assertDontSee('Prof. Dr. Ir. Bambang Suhardi, M.Sc.');

        // Filter prodi RSTJ
        $responseRstj = $this->get(route('profil.peneliti', ['prodi' => 'rstj']));
        $responseRstj->assertStatus(200);
        $responseRstj->assertSee('Prof. Dr. Ir. Bambang Suhardi, M.Sc.');
        $responseRstj->assertDontSee('Dr. Ir. Hendro Wibowo, M.T.');
    }

    public function test_search_by_name_or_keyword_functions_correctly(): void
    {
        $response = $this->get(route('profil.peneliti', ['q' => 'Hendro']));

        $response->assertStatus(200);
        $response->assertSee('Dr. Ir. Hendro Wibowo, M.T.');
        $response->assertDontSee('Prof. Dr. Ir. Bambang Suhardi, M.Sc.');
    }

    public function test_admin_can_access_user_edit_page(): void
    {
        $admin = User::where('role', 'admin')->first();
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($admin)->get(route('admin.users.edit', $dosen));

        $response->assertStatus(200);
        $response->assertSee('Sunting Profil Peneliti & Dosen');
        $response->assertSee($dosen->name);
    }

    public function test_admin_can_update_researcher_profile_via_cms(): void
    {
        $admin = User::where('role', 'admin')->first();
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($admin)->put(route('admin.users.update', $dosen), [
            'name' => 'Dr. Ir. Hendro Wibowo, M.T., IPM.',
            'email' => $dosen->email,
            'role' => 'dosen',
            'nidn_nip' => '0612048001',
            'prodi_id' => $dosen->prodi_id,
            'no_telp' => '081298765432',
            'keahlian' => 'Sistem Pengereman Cerdas & ADAS Kendaraan Berat',
            'sinta_id' => '6012345',
            'scopus_id' => '57219876543',
            'google_scholar' => 'https://scholar.google.com/citations?user=sample',
            'status_aktif' => 1,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'id' => $dosen->id,
            'name' => 'Dr. Ir. Hendro Wibowo, M.T., IPM.',
            'keahlian' => 'Sistem Pengereman Cerdas & ADAS Kendaraan Berat',
        ]);
    }

    public function test_dosen_cannot_access_or_update_other_user_profile(): void
    {
        $dosen = User::where('role', 'dosen')->first();
        $reviewer = User::where('role', 'reviewer')->first();

        $responseGet = $this->actingAs($dosen)->get(route('admin.users.edit', $reviewer));
        $responseGet->assertRedirect('/dosen/dashboard');

        $responsePut = $this->actingAs($dosen)->put(route('admin.users.update', $reviewer), [
            'name' => 'Hacked Name',
            'email' => 'hacked@pktj.ac.id',
            'role' => 'admin',
        ]);
        $responsePut->assertRedirect('/dosen/dashboard');
    }
}
