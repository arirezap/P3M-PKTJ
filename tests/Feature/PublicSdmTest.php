<?php

namespace Tests\Feature;

use App\Models\OrganizationMember;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicSdmTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_sdm_page(): void
    {
        $response = $this->get(route('profil.sdm'));

        $response->assertStatus(200);
        $response->assertSee('Struktur Organisasi');
        $response->assertSee('Sumber Daya Manusia');
        $response->assertSee('Ir. Bambang Istiyanto, M.T.');
        $response->assertSee('Dr. Ir. Hendro Wibowo, M.T.');
        $response->assertSee('Siti Rahmawati, S.Si.T., M.T.');
        $response->assertSee('SK Direktur PKTJ');
    }

    public function test_admin_can_access_organization_cms(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->get(route('admin.organization.index'));

        $response->assertStatus(200);
        $response->assertSee('Struktur Organisasi');
        $response->assertSee('Sumber Daya Manusia');
        $response->assertSee('Susunan Pejabat');
        $response->assertSee('Ir. Bambang Istiyanto, M.T.');
    }

    public function test_guest_cannot_access_organization_cms(): void
    {
        $response = $this->get(route('admin.organization.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_dosen_cannot_access_organization_cms(): void
    {
        $dosen = User::where('role', 'dosen')->first();

        $response = $this->actingAs($dosen)->get(route('admin.organization.index'));
        $response->assertRedirect(route('dosen.dashboard'));
    }

    public function test_admin_can_update_organization_settings(): void
    {
        $admin = User::where('role', 'admin')->first();

        $response = $this->actingAs($admin)->put(route('admin.organization.settings.update'), [
            'org_title' => 'Struktur Organisasi P3M PKTJ Terkini',
            'org_sk_number' => 'SK Direktur PKTJ No. KP.999/PKTJ/2026',
            'org_period' => '2026 – 2030',
            'org_lead_text' => 'Narasi pembaharuan tata kelola P3M PKTJ.',
        ]);

        $response->assertRedirect(route('admin.organization.index'));
        $response->assertSessionHas('success');

        $this->assertEquals('Struktur Organisasi P3M PKTJ Terkini', Setting::get('org_title'));
        $this->assertEquals('SK Direktur PKTJ No. KP.999/PKTJ/2026', Setting::get('org_sk_number'));

        // Verify updated setting shows on public page
        $publicResponse = $this->get(route('profil.sdm'));
        $publicResponse->assertSee('Struktur Organisasi P3M PKTJ Terkini');
        $publicResponse->assertSee('SK Direktur PKTJ No. KP.999/PKTJ/2026');
    }

    public function test_admin_can_upload_organization_chart_image(): void
    {
        Storage::fake('public');
        $admin = User::where('role', 'admin')->first();

        $file = UploadedFile::fake()->image('bagan_struktur.png', 1200, 800);

        $response = $this->actingAs($admin)->put(route('admin.organization.settings.update'), [
            'org_title' => 'Struktur Organisasi P3M PKTJ',
            'org_sk_number' => 'SK.001/PKTJ/2026',
            'org_period' => '2026 – 2031',
            'org_lead_text' => 'Tata kelola P3M PKTJ',
            'org_chart_image' => $file,
        ]);

        $response->assertRedirect(route('admin.organization.index'));
        $chartPath = Setting::get('org_chart_image');
        $this->assertNotNull($chartPath);
        Storage::disk('public')->assertExists($chartPath);
    }

    public function test_admin_can_create_update_and_delete_member(): void
    {
        $admin = User::where('role', 'admin')->first();

        // 1. Create member
        $storeResponse = $this->actingAs($admin)->post(route('admin.organization.members.store'), [
            'nama' => 'Ahmad Fauzi, S.T., M.T.',
            'nip_nidn' => '199001012019031002',
            'jabatan' => 'Koordinator Publikasi Jurnal',
            'urutan' => 9,
            'deskripsi_tugas' => 'Mengawal penerbitan artikel berkala.',
            'status_aktif' => 1,
        ]);

        $storeResponse->assertRedirect(route('admin.organization.index'));
        $this->assertDatabaseHas('organization_members', [
            'nama' => 'Ahmad Fauzi, S.T., M.T.',
            'jabatan' => 'Koordinator Publikasi Jurnal',
        ]);

        $member = OrganizationMember::where('nama', 'Ahmad Fauzi, S.T., M.T.')->first();

        // 2. Update member
        $updateResponse = $this->actingAs($admin)->put(route('admin.organization.members.update', $member), [
            'nama' => 'Dr. Ahmad Fauzi, S.T., M.T.',
            'nip_nidn' => '199001012019031002',
            'jabatan' => 'Koordinator Publikasi Jurnal & Kerjasama',
            'urutan' => 9,
            'deskripsi_tugas' => 'Mengawal penerbitan artikel berkala dan kerjasama mitra.',
            'status_aktif' => 1,
        ]);

        $updateResponse->assertRedirect(route('admin.organization.index'));
        $this->assertDatabaseHas('organization_members', [
            'id' => $member->id,
            'nama' => 'Dr. Ahmad Fauzi, S.T., M.T.',
            'jabatan' => 'Koordinator Publikasi Jurnal & Kerjasama',
        ]);

        // 3. Delete member
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.organization.members.destroy', $member));
        $deleteResponse->assertRedirect(route('admin.organization.index'));
        $this->assertDatabaseMissing('organization_members', [
            'id' => $member->id,
        ]);
    }

    public function test_admin_can_toggle_member_status(): void
    {
        $admin = User::where('role', 'admin')->first();
        $member = OrganizationMember::first();

        $initialStatus = $member->status_aktif;

        $response = $this->actingAs($admin)->patch(route('admin.organization.members.toggle-status', $member));
        $response->assertSessionHas('success');

        $member->refresh();
        $this->assertEquals(!$initialStatus, $member->status_aktif);

        // If inactive, it shouldn't show in active public listing
        if (!$member->status_aktif) {
            $publicResponse = $this->get(route('profil.sdm'));
            $publicResponse->assertDontSee($member->nama);
        }
    }
}
