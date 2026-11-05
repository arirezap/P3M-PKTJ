<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrganizationMember;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * Menampilkan panel pengelolaan struktur organisasi & SDM P3M.
     */
    public function index(): View
    {
        $settings = Setting::where('group', 'organization')->pluck('value', 'key')->toArray();

        $defaultSettings = [
            'org_title' => 'Struktur Organisasi P3M PKTJ',
            'org_sk_number' => 'SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026',
            'org_period' => '2026 – 2031',
            'org_chart_image' => null,
            'org_lead_text' => 'Pusat Penelitian dan Pengabdian kepada Masyarakat (P3M) merupakan unit pelaksana strategis bidang riset terapan dan pengabdian masyarakat di lingkungan Politeknik Keselamatan Transportasi Jalan, berkedudukan langsung di bawah Direktur PKTJ dan dikoordinasikan oleh Wakil Direktur I Bidang Akademik sesuai ketentuan tata kelola Badan Pengembangan SDM Perhubungan.',
        ];

        $mergedSettings = array_merge($defaultSettings, $settings);
        $members = OrganizationMember::ordered()->get();

        return view('admin.organization.index', [
            'settings' => $mergedSettings,
            'members' => $members,
        ]);
    }

    /**
     * Memperbarui pengaturan bagan visual dan dasar hukum SK struktur organisasi.
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'org_title' => ['required', 'string', 'max:255'],
            'org_sk_number' => ['nullable', 'string', 'max:255'],
            'org_period' => ['nullable', 'string', 'max:100'],
            'org_lead_text' => ['nullable', 'string'],
            'org_chart_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ], [
            'org_title.required' => 'Judul struktur organisasi wajib diisi.',
            'org_chart_image.max' => 'Ukuran berkas bagan maksimal 3 MB.',
            'org_chart_image.image' => 'Berkas bagan harus berupa gambar (JPG, PNG, atau WEBP).',
        ]);

        Setting::set('org_title', $validated['org_title'], 'organization');
        Setting::set('org_sk_number', $validated['org_sk_number'] ?? '', 'organization');
        Setting::set('org_period', $validated['org_period'] ?? '', 'organization');
        Setting::set('org_lead_text', $validated['org_lead_text'] ?? '', 'organization');

        if ($request->hasFile('org_chart_image')) {
            $oldImage = Setting::get('org_chart_image');
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            $chartPath = $request->file('org_chart_image')->store('organization', 'public');
            Setting::set('org_chart_image', $chartPath, 'organization');
        }

        return redirect()->route('admin.organization.index')
            ->with('success', 'Pengaturan bagan struktur dan dasar hukum SK berhasil diperbarui.');
    }

    /**
     * Menyimpan data pengurus baru ke dalam struktur organisasi.
     */
    public function storeMember(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip_nidn' => ['nullable', 'string', 'max:50'],
            'jabatan' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0'],
            'deskripsi_tugas' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama.required' => 'Nama lengkap pengurus wajib diisi.',
            'jabatan.required' => 'Jabatan struktural wajib diisi.',
            'urutan.required' => 'Nomor urut hierarki wajib diisi.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('organization/members', 'public');
        }

        OrganizationMember::create([
            'nama' => $validated['nama'],
            'nip_nidn' => $validated['nip_nidn'],
            'jabatan' => $validated['jabatan'],
            'urutan' => $validated['urutan'],
            'deskripsi_tugas' => $validated['deskripsi_tugas'],
            'foto' => $fotoPath,
            'status_aktif' => $request->boolean('status_aktif', true),
        ]);

        return redirect()->route('admin.organization.index')
            ->with('success', "Pengurus {$validated['nama']} berhasil ditambahkan ke struktur organisasi.");
    }

    /**
     * Memperbarui data pengurus pada struktur organisasi.
     */
    public function updateMember(Request $request, OrganizationMember $member): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip_nidn' => ['nullable', 'string', 'max:50'],
            'jabatan' => ['required', 'string', 'max:255'],
            'urutan' => ['required', 'integer', 'min:0'],
            'deskripsi_tugas' => ['nullable', 'string'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama.required' => 'Nama lengkap pengurus wajib diisi.',
            'jabatan.required' => 'Jabatan struktural wajib diisi.',
            'urutan.required' => 'Nomor urut hierarki wajib diisi.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        $data = [
            'nama' => $validated['nama'],
            'nip_nidn' => $validated['nip_nidn'],
            'jabatan' => $validated['jabatan'],
            'urutan' => $validated['urutan'],
            'deskripsi_tugas' => $validated['deskripsi_tugas'],
            'status_aktif' => $request->has('status_aktif') ? (bool) $request->status_aktif : true,
        ];

        if ($request->hasFile('foto')) {
            if ($member->foto && Storage::disk('public')->exists($member->foto)) {
                Storage::disk('public')->delete($member->foto);
            }
            $data['foto'] = $request->file('foto')->store('organization/members', 'public');
        }

        $member->update($data);

        return redirect()->route('admin.organization.index')
            ->with('success', "Data pengurus {$member->nama} berhasil diperbarui.");
    }

    /**
     * Menghapus data pengurus dari struktur organisasi.
     */
    public function destroyMember(OrganizationMember $member): RedirectResponse
    {
        $nama = $member->nama;

        if ($member->foto && Storage::disk('public')->exists($member->foto)) {
            Storage::disk('public')->delete($member->foto);
        }

        $member->delete();

        return redirect()->route('admin.organization.index')
            ->with('success', "Pengurus {$nama} berhasil dihapus dari struktur organisasi.");
    }

    /**
     * Memperbarui susunan nomor urut pengurus struktur organisasi (Drag and Drop / Up-Down Reorder).
     */
    public function reorderMembers(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*.id' => ['required', 'integer', 'exists:organization_members,id'],
            'orders.*.urutan' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($validated) {
            foreach ($validated['orders'] as $item) {
                OrganizationMember::where('id', $item['id'])->update(['urutan' => $item['urutan']]);
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Susunan urutan pengurus struktur organisasi berhasil diperbarui.',
        ]);
    }

    /**
     * Mengubah status keaktifan pengurus.
     */
    public function toggleStatus(OrganizationMember $member): RedirectResponse
    {
        $member->update(['status_aktif' => ! $member->status_aktif]);
        $statusStr = $member->status_aktif ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Status kepengurusan {$member->nama} berhasil {$statusStr}.");
    }
}
