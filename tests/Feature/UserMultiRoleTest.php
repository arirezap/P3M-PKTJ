<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Prodi;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserMultiRoleTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Prodi $prodi;

    protected function setUp(): void
    {
        parent::setUp();

        $this->prodi = Prodi::create([
            'kode_prodi' => 'TRO',
            'nama_prodi' => 'Teknologi Rekayasa Otomotif',
            'jenjang' => 'D4',
            'status_aktif' => true,
        ]);

        $this->admin = User::factory()->create([
            'name' => 'Admin P3M',
            'email' => 'admin@pktj.ac.id',
            'role' => 'admin',
            'roles' => ['admin'],
            'prodi_id' => $this->prodi->id,
            'status_aktif' => true,
        ]);
    }

    public function test_admin_can_view_user_management_with_stats_and_sub_menu(): void
    {
        User::factory()->create([
            'role' => 'dosen',
            'roles' => ['peneliti'],
        ]);

        User::factory()->create([
            'role' => 'reviewer',
            'roles' => ['reviewer'],
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Manajemen Akun Dosen & Reviewer', false);
        $response->assertSee('Semua Pengguna');
        $response->assertSee('Admin');
        $response->assertSee('Reviewer');
        $response->assertSee('Peneliti');
    }

    public function test_admin_can_update_user_roles_via_checkbox_table(): void
    {
        $user = User::factory()->create([
            'name' => 'Dosen Peneliti',
            'email' => 'peneliti@pktj.ac.id',
            'role' => 'dosen',
            'roles' => ['peneliti'],
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.users.update-roles', $user), [
            'roles' => ['peneliti', 'reviewer'],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue($user->hasRole('peneliti'));
        $this->assertTrue($user->hasRole('reviewer'));
        $this->assertFalse($user->hasRole('admin'));
        $this->assertTrue($user->isMultiRole());
    }

    public function test_admin_cannot_revoke_own_admin_role(): void
    {
        $response = $this->actingAs($this->admin)->patch(route('admin.users.update-roles', $this->admin), [
            'roles' => ['peneliti', 'reviewer'],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('error', 'Anda tidak dapat mencabut peran Administrator dari akun Anda sendiri.');

        $this->admin->refresh();
        $this->assertTrue($this->admin->hasRole('admin'));
    }

    public function test_multi_role_user_can_access_both_dosen_and_reviewer_dashboards(): void
    {
        $multiUser = User::factory()->create([
            'name' => 'Dosen Sekaligus Reviewer',
            'email' => 'dosenreviewer@pktj.ac.id',
            'role' => 'reviewer',
            'roles' => ['peneliti', 'reviewer'],
            'status_aktif' => true,
        ]);

        // Akses dashboard dosen
        $dosenResponse = $this->actingAs($multiUser)->get(route('dosen.dashboard'));
        $dosenResponse->assertStatus(200);

        // Akses dashboard reviewer
        $reviewerResponse = $this->actingAs($multiUser)->get(route('reviewer.dashboard'));
        $reviewerResponse->assertStatus(200);
    }

    public function test_sub_menu_tab_filters_users_accurately(): void
    {
        $reviewerOnly = User::factory()->create([
            'name' => 'Reviewer Ahli',
            'email' => 'rev_ahli@pktj.ac.id',
            'role' => 'reviewer',
            'roles' => ['reviewer'],
        ]);

        $penelitiOnly = User::factory()->create([
            'name' => 'Peneliti Murni',
            'email' => 'peneliti_murni@pktj.ac.id',
            'role' => 'dosen',
            'roles' => ['peneliti'],
        ]);

        // Filter Peneliti
        $responsePeneliti = $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'peneliti']));
        $responsePeneliti->assertStatus(200);
        $responsePeneliti->assertSee('Peneliti Murni');
        $responsePeneliti->assertDontSee('Reviewer Ahli');

        // Filter Reviewer
        $responseReviewer = $this->actingAs($this->admin)->get(route('admin.users.index', ['role' => 'reviewer']));
        $responseReviewer->assertStatus(200);
        $responseReviewer->assertSee('Reviewer Ahli');
        $responseReviewer->assertDontSee('Peneliti Murni');
    }

    public function test_admin_can_create_user_with_multiple_roles(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name' => 'Dosen Baru',
            'email' => 'dosenbaru@pktj.ac.id',
            'password' => 'password123',
            'roles' => ['peneliti', 'reviewer'],
            'prodi_id' => $this->prodi->id,
            'nidn_nip' => '1234567890',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $newUser = User::where('email', 'dosenbaru@pktj.ac.id')->first();
        $this->assertNotNull($newUser);
        $this->assertTrue($newUser->hasRole('peneliti'));
        $this->assertTrue($newUser->hasRole('reviewer'));
        $this->assertTrue($newUser->isMultiRole());
    }

    public function test_admin_can_update_user_with_multiple_roles_via_edit_form(): void
    {
        $user = User::factory()->create([
            'name' => 'Dosen Edit',
            'email' => 'dosenedit@pktj.ac.id',
            'role' => 'dosen',
            'roles' => ['peneliti'],
            'prodi_id' => $this->prodi->id,
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), [
            'name' => 'Dosen Edit Terupdate',
            'email' => 'dosenedit@pktj.ac.id',
            'roles' => ['peneliti', 'admin'],
            'prodi_id' => $this->prodi->id,
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertEquals('Dosen Edit Terupdate', $user->name);
        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user->hasRole('peneliti'));
    }
}

