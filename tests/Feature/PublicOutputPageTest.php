<?php

namespace Tests\Feature;

use App\Models\Output;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PublicOutputPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_public_can_access_luaran_penelitian_page(): void
    {
        $response = $this->get(route('riset.luaran'));

        $response->assertStatus(200);
        $response->assertSee('Luaran Penelitian & Pengembangan Vokasi', false);
        $response->assertSee('D4 RSTJ');
        $response->assertSee('D4 TRO');
        $response->assertSee('D3 TO');
        $response->assertSee('Publikasi Ilmiah');
        $response->assertSee('Hak Kekayaan Intelektual (HKI)');
        $response->assertSee('Produk & Jasa Teknologi', false);
        $response->assertSee('Lisensi Terbuka');

        // Verifikasi kanvas grafik Chart.js
        $response->assertSee('id="outputPilarChart"', false);
        $response->assertSee('id="outputProdiChart"', false);

        // Verifikasi kehadiran indikator 4 pemenuhan kebutuhan
        $response->assertSee('Lisensi:');
        $response->assertSee('Roadmap:');
        $response->assertSee('Mitra:');
        $response->assertSee('Dana:');
    }

    public function test_author_inventor_is_clickable_when_user_exists(): void
    {
        $prodi = Prodi::first();
        $user = User::factory()->create([
            'role' => 'dosen',
            'name' => 'Dr. Inventor Mandiri, M.T.',
            'status_aktif' => true,
        ]);

        $output = Output::create([
            'kategori' => 'publikasi',
            'judul' => 'Inovasi Deteksi Kelelahan Pengemudi Angkutan Barang Vokasi',
            'prodi_id' => $prodi->id,
            'user_id' => $user->id,
            'author_inventor' => 'Dr. Inventor Mandiri, M.T.',
            'tahun' => 2026,
            'nama_jurnal_penerbit' => 'Jurnal Keselamatan Transportasi Jalan',
            'lisensi' => 'CC-BY-SA 4.0 Open Access',
            'fase_roadmap' => 'Fase 4: Hilirisasi',
            'mitra_kerjasama' => 'KNKT & Dishub',
            'sumber_dana' => 'DIPA PKTJ',
            'realisasi_dana' => 50000000,
        ]);

        $response = $this->get(route('riset.luaran', ['q' => 'Inovasi Deteksi Kelelahan Pengemudi Angkutan Barang Vokasi']));

        $response->assertStatus(200);
        $response->assertSee($output->judul);
        $response->assertSee(route('profil.peneliti.show', $user));
    }

    public function test_real_2025_outputs_data_from_excel_is_seeded_without_duplicates(): void
    {
        $outputs2025 = Output::where('tahun', 2025)->get();
        $this->assertCount(184, $outputs2025);

        $this->assertEquals(165, $outputs2025->where('kategori', 'publikasi')->count());
        $this->assertEquals(6, $outputs2025->where('kategori', 'produk')->count());
        $this->assertEquals(13, $outputs2025->where('kategori', 'hki')->count());

        // Pastikan tidak ada duplikasi judul dalam kategori yang sama
        $uniquePairs = $outputs2025->map(fn ($o) => strtolower(trim($o->kategori)).'|'.strtolower(trim($o->judul)))->unique();
        $this->assertCount(184, $uniquePairs);

        // Pastikan seluruh realisasi dana 2025 dari spreadsheet bernilai 0
        $this->assertEquals(0, (int) $outputs2025->sum('realisasi_dana'));
    }

    public function test_filter_by_kategori_tabs(): void
    {
        // 1. Tab Publikasi
        $responsePub = $this->get(route('riset.luaran', ['kategori' => 'publikasi']));
        $responsePub->assertStatus(200);

        // 2. Tab HKI
        $responseHki = $this->get(route('riset.luaran', ['kategori' => 'hki']));
        $responseHki->assertStatus(200);

        // 3. Tab Produk
        $responseProd = $this->get(route('riset.luaran', ['kategori' => 'produk']));
        $responseProd->assertStatus(200);
    }

    public function test_filter_by_prodi(): void
    {
        $rstjProdi = Prodi::where('kode_prodi', 'RSTJ')->first();
        $this->assertNotNull($rstjProdi);

        $response = $this->get(route('riset.luaran', ['prodi' => 'RSTJ']));
        $response->assertStatus(200);
        $response->assertSee('D4 RSTJ');
    }

    public function test_filter_by_year(): void
    {
        $response = $this->get(route('riset.luaran', ['tahun' => 2026]));
        $response->assertStatus(200);
        $response->assertSee('2026');
    }

    public function test_filter_by_open_license(): void
    {
        $response = $this->get(route('riset.luaran', ['lisensi' => 'terbuka']));
        $response->assertStatus(200);
        $response->assertSee('Lisensi Terbuka');
    }

    public function test_keyword_search(): void
    {
        $output = Output::first();
        $this->assertNotNull($output);

        $keyword = substr($output->judul, 0, 8);
        $response = $this->get(route('riset.luaran', ['q' => $keyword]));

        $response->assertStatus(200);
        $response->assertSee($output->judul);
    }

    public function test_download_output_pdf(): void
    {
        Storage::fake('public');

        $output = Output::first();
        $filePath = 'outputs/sample_output.pdf';
        Storage::disk('public')->put($filePath, '%PDF-1.4 sample content for output test');

        $output->update(['berkas_luaran' => $filePath]);

        $response = $this->get(route('riset.luaran.unduh', $output));
        $response->assertOk();

        // Uji kasus berkas tidak ada
        $outputEmpty = Output::create([
            'kategori' => 'publikasi',
            'judul' => 'Output Tanpa Berkas PDF Bukti',
            'author_inventor' => 'Dr. Contoh Peneliti, M.T.',
            'tahun' => 2026,
            'nama_jurnal_penerbit' => 'Jurnal Keselamatan Transportasi',
            'prodi_id' => $output->prodi_id,
            'berkas_luaran' => null,
        ]);

        $failResponse = $this->get(route('riset.luaran.unduh', $outputEmpty));
        $failResponse->assertRedirect();
        $failResponse->assertSessionHas('error');
    }

    public function test_admin_can_manage_output_via_cms(): void
    {
        Storage::fake('public');

        $admin = User::where('role', 'admin')->first();
        $prodi = Prodi::where('kode_prodi', 'RSTJ')->first();
        $this->assertNotNull($admin);
        $this->assertNotNull($prodi);

        $pdfFile = UploadedFile::fake()->create('hki_sertifikat.pdf', 1024, 'application/pdf');

        // 1. Simpan Data Baru
        $storeResponse = $this->actingAs($admin)->post(route('admin.outputs.store'), [
            'kategori' => 'hki',
            'judul' => 'Sistem Deteksi Pelanggaran Muatan Truk ODOL Berbasis Sensor Getar',
            'author_inventor' => 'Dr. Ir. Budi Hartono, M.T.',
            'prodi_id' => $prodi->id,
            'tahun' => 2026,
            'nomor_registrasi_hki' => 'IDS000008899',
            'tingkat_kesiapan_terapan' => 'TKT 7',
            'lisensi' => 'Paten Sederhana Terdaftar',
            'fase_roadmap' => 'Fase IV (2025-2026): Hilirisasi & Kolaborasi',
            'deskripsi_kemanfaatan' => 'Mencegah kerusakan jalan nasional melalui deteksi otomatis muatan berlebih.',
            'mitra_kerjasama' => 'Balai Pengelola Transportasi Darat (BPTD)',
            'sumber_dana' => 'DIPA PKTJ',
            'realisasi_dana' => 60000000,
            'link_dokumen' => 'https://pdki-indonesia.dgip.go.id',
            'berkas_luaran' => $pdfFile,
        ]);

        $storeResponse->assertRedirect(route('admin.outputs.index'));
        $storeResponse->assertSessionHas('success');

        $created = Output::where('judul', 'Sistem Deteksi Pelanggaran Muatan Truk ODOL Berbasis Sensor Getar')->first();
        $this->assertNotNull($created);
        $this->assertNotNull($created->berkas_luaran);
        Storage::disk('public')->assertExists($created->berkas_luaran);

        // 2. Perbarui Data dengan Penggantian File
        $newPdf = UploadedFile::fake()->create('sertifikat_final.pdf', 1500, 'application/pdf');
        $oldPath = $created->berkas_luaran;

        $updateResponse = $this->actingAs($admin)->put(route('admin.outputs.update', $created), [
            'kategori' => 'hki',
            'judul' => 'Sistem Deteksi ODOL Sensor Getar - Edisi Final Terdaftar',
            'author_inventor' => 'Dr. Ir. Budi Hartono, M.T.',
            'prodi_id' => $prodi->id,
            'tahun' => 2026,
            'nomor_registrasi_hki' => 'IDS000008899-REV',
            'tingkat_kesiapan_terapan' => 'TKT 8',
            'lisensi' => 'Paten Sederhana Terdaftar',
            'fase_roadmap' => 'Fase IV (2025-2026): Hilirisasi & Kolaborasi',
            'deskripsi_kemanfaatan' => 'Implementasi terpasang di Jembatan Timbang.',
            'mitra_kerjasama' => 'BPTD Wilayah Jawa Tengah',
            'sumber_dana' => 'DIPA PKTJ',
            'realisasi_dana' => 65000000,
            'berkas_luaran' => $newPdf,
        ]);

        $updateResponse->assertRedirect(route('admin.outputs.index'));
        $updateResponse->assertSessionHas('success');

        $updated = $created->fresh();
        $this->assertEquals('Sistem Deteksi ODOL Sensor Getar - Edisi Final Terdaftar', $updated->judul);
        $this->assertNotEquals($oldPath, $updated->berkas_luaran);
        Storage::disk('public')->assertMissing($oldPath);
        Storage::disk('public')->assertExists($updated->berkas_luaran);

        // 3. Verifikasi Muncul di Halaman Publik
        $publicCheck = $this->get(route('riset.luaran', ['kategori' => 'hki']));
        $publicCheck->assertStatus(200);
        $publicCheck->assertSee('Sistem Deteksi ODOL Sensor Getar - Edisi Final Terdaftar');

        // 4. Hapus Data
        $deleteResponse = $this->actingAs($admin)->delete(route('admin.outputs.destroy', $updated));
        $deleteResponse->assertRedirect(route('admin.outputs.index'));
        $this->assertDatabaseMissing('outputs', ['id' => $updated->id]);
        Storage::disk('public')->assertMissing($updated->berkas_luaran);
    }

    public function test_guest_and_dosen_cannot_manage_outputs(): void
    {
        $dosen = User::where('role', 'dosen')->first();
        $this->assertNotNull($dosen);

        // Tamu ditolak ke login
        $guestResponse = $this->get(route('admin.outputs.index'));
        $guestResponse->assertRedirect(route('login'));

        // Dosen ditolak dari akses admin dan dialihkan ke dasbor perannya
        $dosenResponse = $this->actingAs($dosen)->get(route('admin.outputs.index'));
        $dosenResponse->assertRedirect('/dosen/dashboard');
    }
}
