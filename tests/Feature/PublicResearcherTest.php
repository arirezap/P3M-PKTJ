<?php

namespace Tests\Feature;

use App\Models\Prodi;
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
        $response->assertSee('Aat Eska Fahmadi');
        $response->assertSee('Anton Budiharjo');

        $searchResponse = $this->get(route('profil.peneliti', ['q' => 'Bambang Suhardi']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertSee('Prof. Dr. Ir. Bambang Suhardi, M.Sc.');
    }

    public function test_researcher_name_is_clickable_and_links_to_detail_page(): void
    {
        $hendro = User::where('name', 'like', '%Hendro Wibowo%')->first();
        $this->assertNotNull($hendro);

        $response = $this->get(route('profil.peneliti', ['q' => 'Hendro Wibowo']));
        $response->assertStatus(200);

        // Pastikan nama dosen dan tombol berwujud tautan ke rute profil.peneliti.show
        $response->assertSee(route('profil.peneliti.show', $hendro));
        $response->assertSee('Lihat Rekap Riset dan Publikasi');
    }

    public function test_public_can_access_researcher_detail_page_and_view_research_and_outputs(): void
    {
        $hendro = User::where('name', 'like', '%Hendro Wibowo%')->first();
        $this->assertNotNull($hendro);

        $response = $this->get(route('profil.peneliti.show', $hendro));

        $response->assertStatus(200);
        $response->assertSee($hendro->name);
        $response->assertSee('Data Kegiatan Penelitian');
        $response->assertSee('Data Publikasi Ilmiah & Luaran HKI');
        // Hendro memiliki data riset dan luaran
        $response->assertSee('Sensor Deteksi Kelelahan');
        $response->assertSee('Driver Drowsiness Detection System');
        $response->assertSee('Kembali ke Direktori');
    }

    public function test_inactive_researcher_detail_returns_404(): void
    {
        $dosen = User::where('role', 'dosen')->first();
        $dosen->update(['status_aktif' => false]);

        $response = $this->get(route('profil.peneliti.show', $dosen));
        $response->assertStatus(404);
    }

    public function test_filter_by_prodi_functions_correctly(): void
    {
        // Filter prodi TRO
        $responseTro = $this->get(route('profil.peneliti', ['prodi' => 'tro']));
        $responseTro->assertStatus(200);
        $responseTro->assertSee('Agus Setiawan, M.T.');
        $responseTro->assertDontSee('Anton Budiharjo');

        // Filter prodi RSTJ
        $responseRstj = $this->get(route('profil.peneliti', ['prodi' => 'rstj']));
        $responseRstj->assertStatus(200);
        $responseRstj->assertSee('Anton Budiharjo');
        $responseRstj->assertDontSee('Agus Setiawan, M.T.');
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
