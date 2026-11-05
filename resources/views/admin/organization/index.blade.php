@extends('layouts.admin')

@section('title', 'Struktur Organisasi & Tata Kelola P3M')
@section('breadcrumb', 'CMS Portal / Profil / Struktur Organisasi')

@section('content')
<div class="space-y-8 max-w-6xl mx-auto" x-data="{ 
    members: {{ $members->map(fn($m) => [
        'id' => $m->id,
        'nama' => $m->nama,
        'nip_nidn' => $m->nip_nidn ?? '',
        'jabatan' => $m->jabatan,
        'urutan' => (int)$m->urutan,
        'deskripsi_tugas' => $m->deskripsi_tugas ?? '',
        'status_aktif' => (bool)$m->status_aktif,
        'foto' => $m->foto,
        'foto_url' => $m->foto ? asset('storage/' . $m->foto) : null,
        'initials' => strtoupper(substr($m->nama, 0, 2)),
        'toggle_url' => route('admin.organization.members.toggle-status', $m),
        'destroy_url' => route('admin.organization.members.destroy', $m),
        'update_url' => route('admin.organization.members.update', $m),
    ])->toJson() }},
    draggedIdx: null,
    dragOverIdx: null,
    isSaving: false,
    toastMessage: '',
    toastSuccess: true,
    addModalOpen: false, 
    editModalOpen: false,
    showTreePreview: true,
    editData: {
        id: '',
        nama: '',
        nip_nidn: '',
        jabatan: '',
        urutan: 1,
        deskripsi_tugas: '',
        status_aktif: true,
        foto_url: ''
    },
    openEdit(member) {
        this.editData = {
            id: member.id,
            nama: member.nama,
            nip_nidn: member.nip_nidn || '',
            jabatan: member.jabatan,
            urutan: member.urutan,
            deskripsi_tugas: member.deskripsi_tugas || '',
            status_aktif: Boolean(member.status_aktif),
            foto_url: member.foto ? '{{ asset('storage') }}/' + member.foto : ''
        };
        this.editModalOpen = true;
    },
    onDragStart(idx, e) {
        this.draggedIdx = idx;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', idx);
    },
    onDragOver(idx, e) {
        e.preventDefault();
        this.dragOverIdx = idx;
    },
    onDrop(targetIdx, e) {
        e.preventDefault();
        if (this.draggedIdx === null || this.draggedIdx === targetIdx) {
            this.draggedIdx = null;
            this.dragOverIdx = null;
            return;
        }
        const movedItem = this.members.splice(this.draggedIdx, 1)[0];
        this.members.splice(targetIdx, 0, movedItem);
        this.draggedIdx = null;
        this.dragOverIdx = null;
        this.reindexAndSave();
    },
    moveUp(idx) {
        if (idx <= 0) return;
        const item = this.members.splice(idx, 1)[0];
        this.members.splice(idx - 1, 0, item);
        this.reindexAndSave();
    },
    moveDown(idx) {
        if (idx >= this.members.length - 1) return;
        const item = this.members.splice(idx, 1)[0];
        this.members.splice(idx + 1, 0, item);
        this.reindexAndSave();
    },
    async reindexAndSave() {
        this.members.forEach((m, i) => {
            m.urutan = i + 1;
        });
        this.isSaving = true;
        try {
            const payload = this.members.map(m => ({ id: m.id, urutan: m.urutan }));
            const res = await fetch('{{ route('admin.organization.members.reorder') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ orders: payload })
            });
            const data = await res.json();
            if (data.success) {
                this.toastSuccess = true;
                this.toastMessage = 'Susunan urutan pengurus berhasil diperbarui.';
                setTimeout(() => { this.toastMessage = ''; }, 3000);
            } else {
                throw new Error(data.message || 'Gagal menyimpan.');
            }
        } catch (err) {
            this.toastSuccess = false;
            this.toastMessage = 'Terjadi kendala saat menyimpan urutan: ' + err.message;
            setTimeout(() => { this.toastMessage = ''; }, 4000);
        } finally {
            this.isSaving = false;
        }
    },
    get pengarahMembers() {
        return this.members.filter(m => m.status_aktif && (m.jabatan.toLowerCase().includes('pengarah') || m.jabatan.toLowerCase().includes('pelindung') || m.jabatan.toLowerCase().includes('direktur')) && !m.jabatan.toLowerCase().includes('wakil'));
    },
    get penanggungJawabMembers() {
        return this.members.filter(m => m.status_aktif && !this.pengarahMembers.includes(m) && (m.jabatan.toLowerCase().includes('penanggung jawab') || m.jabatan.toLowerCase().includes('wakil direktur') || m.jabatan.toLowerCase().includes('wadir')));
    },
    get pimpinanMembers() {
        return this.members.filter(m => m.status_aktif && !this.pengarahMembers.includes(m) && !this.penanggungJawabMembers.includes(m) && (m.jabatan.toLowerCase().includes('kepala pusat') || m.jabatan.toLowerCase().includes('kepala p3m') || m.jabatan.toLowerCase().includes('sekretaris')));
    },
    get koordinatorMembers() {
        return this.members.filter(m => m.status_aktif && !this.pengarahMembers.includes(m) && !this.penanggungJawabMembers.includes(m) && !this.pimpinanMembers.includes(m) && (m.jabatan.toLowerCase().includes('koordinator') || m.jabatan.toLowerCase().includes('bidang') || m.jabatan.toLowerCase().includes('sentra')));
    },
    get stafMembers() {
        return this.members.filter(m => m.status_aktif && !this.pengarahMembers.includes(m) && !this.penanggungJawabMembers.includes(m) && !this.pimpinanMembers.includes(m) && !this.koordinatorMembers.includes(m));
    }
}">
    
    <!-- Header Halaman & Tombol Aksi -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 border border-blue-200 text-[#0B2A59] text-xs font-semibold leading-4 mb-2">
                <span>Profil Kelembagaan PKTJ</span>
            </div>
            <h1 class="text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">Struktur Organisasi & Sumber Daya Manusia</h1>
            <p class="text-xs text-slate-500 mt-1 leading-5">Kelola bagan visual, legalitas SK Direktur PKTJ, dan susunan pejabat struktural pengelola P3M secara dinamis.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('profil.sdm') }}" target="_blank" 
               class="inline-flex items-center gap-2 h-11 px-4 text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 rounded-xl transition-all shadow-sm leading-4">
                <span>Lihat Tampilan Publik</span>
                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
            </a>
            <button @click="addModalOpen = true" type="button" 
                    class="inline-flex items-center gap-2 h-11 px-5 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Pengurus Baru</span>
            </button>
        </div>
    </div>

    <!-- Toast Notifikasi Reorder Dinamis -->
    <div x-show="toastMessage" x-cloak 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         :class="toastSuccess ? 'bg-emerald-50 border-emerald-200 text-emerald-800' : 'bg-rose-50 border-rose-200 text-rose-800'"
         class="p-4 rounded-xl border text-xs flex items-center justify-between shadow-sm leading-5">
        <div class="flex items-center gap-2">
            <template x-if="toastSuccess">
                <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </template>
            <template x-if="!toastSuccess">
                <svg class="w-4 h-4 text-rose-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </template>
            <span x-text="toastMessage" class="font-medium"></span>
        </div>
        <button @click="toastMessage = ''" type="button" class="text-slate-400 hover:text-slate-600">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Alert Notifikasi Validasi Error -->
    @if($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1 shadow-sm">
            <div class="font-bold flex items-center gap-2 leading-4">
                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Mohon periksa kembali isian formulir:</span>
            </div>
            <ul class="list-disc list-inside pl-4 space-y-0.5 leading-4">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Bagian 1: Pengaturan Bagan Visual & Dasar Hukum SK -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="border-b border-slate-100 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 1</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Pengaturan Bagan Visual & Dasar Hukum SK</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Bagan hierarki organisasi dan surat keputusan penetapan struktur pengelola P3M.</p>
            </div>
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600 leading-4">
                Periode: {{ $settings['org_period'] ?? '-' }}
            </span>
        </div>

        <form method="POST" action="{{ route('admin.organization.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Judul Halaman / Bagan -->
                <div class="md:col-span-2">
                    <label for="org_title" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Judul Utama Bagan Organisasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="org_title" name="org_title" 
                           value="{{ old('org_title', $settings['org_title'] ?? 'Struktur Organisasi P3M PKTJ') }}" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <!-- Nomor SK Penetapan -->
                <div>
                    <label for="org_sk_number" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Nomor SK Penetapan Direktur PKTJ
                    </label>
                    <input type="text" id="org_sk_number" name="org_sk_number" 
                           value="{{ old('org_sk_number', $settings['org_sk_number'] ?? '') }}"
                           placeholder="Contoh: SK Direktur PKTJ No. KP.004/1/12/PKTJ-2026"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <!-- Periode Masa Bakti -->
                <div>
                    <label for="org_period" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Masa Bakti / Periode Kepengurusan
                    </label>
                    <input type="text" id="org_period" name="org_period" 
                           value="{{ old('org_period', $settings['org_period'] ?? '') }}"
                           placeholder="Contoh: 2026 – 2031"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <!-- Narasi Pengantar Organisasi -->
                <div class="md:col-span-2">
                    <label for="org_lead_text" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Narasi Pengantar Tata Kelola Kelembagaan
                    </label>
                    <textarea id="org_lead_text" name="org_lead_text" rows="3"
                              class="w-full p-4 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">{{ old('org_lead_text', $settings['org_lead_text'] ?? '') }}</textarea>
                </div>

                <!-- Berkas Bagan Struktur Organisasi -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                        Unggah Bagan Struktur Organisasi (Gambar)
                    </label>
                    <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        @if(!empty($settings['org_chart_image']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['org_chart_image']))
                            <div class="relative w-40 h-28 rounded-xl overflow-hidden border border-slate-300 bg-white flex-shrink-0 shadow-sm">
                                <img src="{{ asset('storage/' . $settings['org_chart_image']) }}" alt="Bagan Struktur Organisasi" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-40 h-28 rounded-xl border border-dashed border-slate-300 bg-white flex flex-col items-center justify-center text-slate-400 text-xs flex-shrink-0 p-2 text-center">
                                <svg class="w-8 h-8 text-slate-300 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Belum ada bagan visual</span>
                            </div>
                        @endif

                        <div class="space-y-2 flex-1">
                            <input type="file" name="org_chart_image" accept="image/png,image/jpeg,image/webp"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
                            <p class="text-xs text-slate-400 leading-4">Format berkas: JPG, PNG, atau WEBP. Ukuran file maksimal 3 MB. Direkomendasikan gambar diagram landscape dengan resolusi minimal 1200 x 800 pixel.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" 
                        class="h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                    Simpan Pengaturan Struktur
                </button>
            </div>
        </form>
    </div>

    <!-- Bagian 2: Susunan Pejabat & Pengurus (Drag & Drop Reordering) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Bagian 2</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Susunan Pejabat & Pengurus Struktural</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">
                    Geser baris (drag and drop) atau gunakan tombol panah untuk mengatur urutan hierarki personil. Perubahan langsung disimpan otomatis.
                </p>
            </div>
            <div class="flex items-center gap-3">
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-[#0B2A59] text-xs font-semibold leading-4">
                    <span x-show="isSaving" class="inline-block w-2 h-2 rounded-full bg-yellow-500 animate-ping mr-1"></span>
                    <span x-text="isSaving ? 'Menyimpan...' : 'Tersinkronisasi'"></span>
                </div>
                <div class="text-xs text-slate-500 font-medium">
                    Total: <span class="font-bold text-[#0B2A59]" x-text="members.length + ' orang'"></span>
                </div>
            </div>
        </div>

        <!-- Tabel Susunan Pengurus dengan Drag & Drop -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <th class="py-3.5 px-3 w-12 text-center" title="Geser untuk mengatur urutan">Seret</th>
                        <th class="py-3.5 px-3 w-16 text-center">Urutan</th>
                        <th class="py-3.5 px-4">Nama Lengkap & NIP</th>
                        <th class="py-3.5 px-4">Jabatan Struktural</th>
                        <th class="py-3.5 px-4">Deskripsi Tugas & Peran</th>
                        <th class="py-3.5 px-4 text-center">Status</th>
                        <th class="py-3.5 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <template x-for="(m, index) in members" :key="m.id">
                        <tr draggable="true"
                            @dragstart="onDragStart(index, $event)"
                            @dragover="onDragOver(index, $event)"
                            @drop="onDrop(index, $event)"
                            :class="{
                                'opacity-40 bg-blue-50': draggedIdx === index,
                                'border-t-2 border-[#0B2A59] bg-slate-50': dragOverIdx === index && draggedIdx !== index
                            }"
                            class="hover:bg-slate-50/80 transition-all cursor-move select-none">
                            
                            <!-- Grip Drag Handle -->
                            <td class="py-3.5 px-3 text-center text-slate-400 hover:text-[#0B2A59]">
                                <svg class="w-4 h-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16" />
                                </svg>
                            </td>

                            <!-- Nomor Urut & Tombol Naik/Turun -->
                            <td class="py-3.5 px-3 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-[#0B2A59] font-bold text-xs"
                                          x-text="m.urutan">
                                    </span>
                                    <div class="flex flex-col gap-0.5">
                                        <button @click="moveUp(index)" type="button" :disabled="index === 0"
                                                class="w-4 h-3.5 flex items-center justify-center text-slate-400 hover:text-[#0B2A59] disabled:opacity-20 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                        </button>
                                        <button @click="moveDown(index)" type="button" :disabled="index === members.length - 1"
                                                class="w-4 h-3.5 flex items-center justify-center text-slate-400 hover:text-[#0B2A59] disabled:opacity-20 disabled:cursor-not-allowed">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                    </div>
                                </div>
                            </td>

                            <!-- Profil & Nama -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <template x-if="m.foto_url">
                                        <img :src="m.foto_url" :alt="m.nama" 
                                             class="w-10 h-10 rounded-full object-cover border border-slate-200 flex-shrink-0 shadow-xs">
                                    </template>
                                    <template x-if="!m.foto_url">
                                        <div class="w-10 h-10 rounded-full bg-[#0B2A59]/10 text-[#0B2A59] font-bold text-xs flex items-center justify-center flex-shrink-0 border border-blue-200"
                                             x-text="m.initials">
                                        </div>
                                    </template>
                                    <div>
                                        <div class="font-bold text-slate-900 leading-5 text-sm" x-text="m.nama"></div>
                                        <div class="text-xs text-slate-500 mt-0.5 font-mono" x-text="m.nip_nidn ? 'NIP: ' + m.nip_nidn : 'NIP: -'"></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jabatan Struktural -->
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold leading-4"
                                      :class="{
                                          'bg-amber-100 text-amber-800': m.jabatan.toLowerCase().includes('pengarah') || m.jabatan.toLowerCase().includes('direktur'),
                                          'bg-blue-100 text-[#0B2A59]': m.jabatan.toLowerCase().includes('kepala') || m.jabatan.toLowerCase().includes('sekretaris') || m.jabatan.toLowerCase().includes('penanggung jawab'),
                                          'bg-slate-100 text-slate-700': !m.jabatan.toLowerCase().includes('pengarah') && !m.jabatan.toLowerCase().includes('direktur') && !m.jabatan.toLowerCase().includes('kepala')
                                      }"
                                      x-text="m.jabatan">
                                </span>
                            </td>

                            <!-- Deskripsi Tugas -->
                            <td class="py-3.5 px-4 max-w-xs text-slate-600 leading-5">
                                <p class="line-clamp-2 text-xs" x-text="m.deskripsi_tugas || '-'"></p>
                            </td>

                            <!-- Status Keaktifan -->
                            <td class="py-3.5 px-4 text-center">
                                <form method="POST" :action="m.toggle_url">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold leading-4 transition-colors"
                                            :class="m.status_aktif ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5" :class="m.status_aktif ? 'bg-emerald-500' : 'bg-slate-400'"></span>
                                        <span x-text="m.status_aktif ? 'Aktif' : 'Nonaktif'"></span>
                                    </button>
                                </form>
                            </td>

                            <!-- Tombol Aksi -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5">
                                    <button @click="openEdit(m)" type="button" 
                                            title="Ubah Data Pengurus"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-slate-600 hover:text-[#0B2A59] hover:bg-slate-100 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <form method="POST" :action="m.destroy_url" 
                                          :onsubmit="'return confirm(\'Apakah Anda yakin ingin menghapus ' + m.nama + ' dari struktur organisasi?\')'">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Pengurus"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    </template>
                    <tr x-show="members.length === 0">
                        <td colspan="7" class="py-8 px-4 text-center text-slate-400">
                            <p class="text-sm">Belum ada personil dalam struktur organisasi.</p>
                            <p class="text-xs mt-1">Silakan klik tombol "+ Tambah Pengurus Baru" di atas untuk menambahkan data.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bagian 3: Pratinjau Interaktif Pohon Organisasi (Live Dynamic Tree Preview) -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pratinjau Langsung</span>
                <h2 class="text-lg font-bold text-[#0B2A59] leading-6">Pohon Struktur Organisasi Dinamis</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Pratinjau visual susunan hierarki yang akan ditampilkan secara otomatis pada halaman publik.</p>
            </div>
            <button @click="showTreePreview = !showTreePreview" type="button" 
                    class="inline-flex items-center gap-2 h-9 px-3 rounded-lg text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                <span x-text="showTreePreview ? 'Sembunyikan Pratinjau' : 'Tampilkan Pratinjau'"></span>
            </button>
        </div>

        <div x-show="showTreePreview" class="bg-slate-50 border border-slate-200 rounded-2xl p-6">
            <div class="max-w-4xl mx-auto space-y-6">
                
                <!-- Tingkat 1: Pengarah / Pelindung -->
                <div x-show="pengarahMembers.length > 0" class="flex flex-col items-center">
                    <div class="flex flex-wrap justify-center gap-4 w-full">
                        <template x-for="p in pengarahMembers" :key="p.id">
                            <div class="bg-[#0B2A59] text-white border-2 border-yellow-400 rounded-2xl p-4 shadow-sm w-full max-w-sm text-center space-y-1">
                                <span class="text-xs font-bold uppercase tracking-wider text-yellow-300" x-text="p.jabatan"></span>
                                <h3 class="text-sm font-bold text-white leading-5" x-text="p.nama"></h3>
                                <p x-show="p.nip_nidn" class="text-xs text-blue-200 leading-4 font-mono" x-text="'NIP: ' + p.nip_nidn"></p>
                            </div>
                        </template>
                    </div>
                    <div class="w-0.5 h-6 bg-slate-300"></div>
                </div>

                <!-- Tingkat 2: Penanggung Jawab Akademik & Riset -->
                <div x-show="penanggungJawabMembers.length > 0" class="flex flex-col items-center">
                    <div class="flex flex-wrap justify-center gap-4 w-full">
                        <template x-for="p in penanggungJawabMembers" :key="p.id">
                            <div class="bg-white border-2 border-[#0B2A59] rounded-2xl p-4 shadow-sm w-full max-w-sm text-center space-y-1">
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-700" x-text="p.jabatan"></span>
                                <h3 class="text-sm font-bold text-[#0B2A59] leading-5" x-text="p.nama"></h3>
                                <p x-show="p.nip_nidn" class="text-xs text-slate-500 leading-4 font-mono" x-text="'NIP: ' + p.nip_nidn"></p>
                            </div>
                        </template>
                    </div>
                    <div class="w-0.5 h-6 bg-slate-300"></div>
                </div>

                <!-- Tingkat 3: Pimpinan Inti P3M -->
                <div x-show="pimpinanMembers.length > 0" class="flex flex-col items-center">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl w-full">
                        <template x-for="p in pimpinanMembers" :key="p.id">
                            <div class="bg-blue-50 border border-blue-200 rounded-2xl p-4 text-center space-y-1">
                                <span class="text-xs font-bold uppercase tracking-wider text-[#0B2A59]" x-text="p.jabatan"></span>
                                <h3 class="text-sm font-bold text-[#0B2A59] leading-5" x-text="p.nama"></h3>
                                <p x-show="p.nip_nidn" class="text-xs text-slate-600 leading-4 font-mono" x-text="'NIP: ' + p.nip_nidn"></p>
                            </div>
                        </template>
                    </div>
                    <div class="w-0.5 h-6 bg-slate-300"></div>
                </div>

                <!-- Tingkat 4: Koordinator Bidang -->
                <div x-show="koordinatorMembers.length > 0" class="flex flex-col items-center">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 w-full">
                        <template x-for="p in koordinatorMembers" :key="p.id">
                            <div class="bg-white border border-slate-200 rounded-2xl p-4 text-center space-y-1 shadow-xs">
                                <span class="text-xs font-bold uppercase tracking-wider text-amber-600" x-text="p.jabatan"></span>
                                <h3 class="text-xs font-bold text-slate-900 leading-4" x-text="p.nama"></h3>
                                <p x-show="p.nip_nidn" class="text-xs text-slate-500 leading-4 font-mono" x-text="'NIP: ' + p.nip_nidn"></p>
                            </div>
                        </template>
                    </div>
                    <div x-show="stafMembers.length > 0" class="w-0.5 h-6 bg-slate-300"></div>
                </div>

                <!-- Tingkat 5: Staf Administrasi & Pengelola SIM -->
                <div x-show="stafMembers.length > 0" class="flex flex-col items-center">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-xl w-full">
                        <template x-for="p in stafMembers" :key="p.id">
                            <div class="bg-slate-100 border border-slate-200 rounded-2xl p-3 text-center space-y-0.5">
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-500" x-text="p.jabatan"></span>
                                <h3 class="text-xs font-bold text-slate-800 leading-4" x-text="p.nama"></h3>
                                <p x-show="p.nip_nidn" class="text-xs text-slate-500 leading-4 font-mono" x-text="'NIP: ' + p.nip_nidn"></p>
                            </div>
                        </template>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Tambah Pengurus Baru -->
    <div x-show="addModalOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="addModalOpen = false" 
             class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Tambah Pengurus Baru</h3>
                    <p class="text-xs text-slate-500 mt-0.5 leading-4">Masukkan data personil ke dalam susunan struktur organisasi P3M.</p>
                </div>
                <button @click="addModalOpen = false" type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form method="POST" action="{{ route('admin.organization.members.store') }}" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" required placeholder="Contoh: Dr. Ir. Budi Santoso, M.T."
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">NIP / NIDN</label>
                        <input type="text" name="nip_nidn" placeholder="198004122008121001"
                               class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Urutan Hierarki <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" :value="members.length + 1" min="0" required
                               class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Jabatan Struktural <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" required placeholder="Contoh: Koordinator Bidang Penelitian & Hilirisasi"
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Deskripsi Tugas & Tanggung Jawab</label>
                    <textarea name="deskripsi_tugas" rows="3" placeholder="Jelaskan peran pokok dan wewenang pengurus dalam kelembagaan..."
                              class="w-full p-4 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Foto Profil Pengurus</label>
                    <input type="file" name="foto" accept="image/png,image/jpeg,image/webp"
                           class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                    <p class="text-xs text-slate-400 mt-1 leading-4">Format: JPG, PNG, atau WEBP. Maksimal 2 MB.</p>
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="status_aktif" value="1" checked class="w-4 h-4 rounded text-[#0B2A59] focus:ring-[#0B2A59] border-slate-300">
                        <span class="text-xs font-medium text-slate-700 leading-4">Aktifkan pengurus pada struktur organisasi publik</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button @click="addModalOpen = false" type="button" 
                            class="h-11 px-5 rounded-xl text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 leading-4">
                        Batal
                    </button>
                    <button type="submit" 
                            class="h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all leading-4">
                        Simpan Pengurus
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Ubah Data Pengurus -->
    <div x-show="editModalOpen" x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="editModalOpen = false" 
             class="bg-white rounded-2xl max-w-xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 space-y-6">
            
            <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-[#0B2A59] leading-6">Ubah Data Pengurus</h3>
                    <p class="text-xs text-slate-500 mt-0.5 leading-4">Perbarui rincian informasi dan penugasan struktural pengurus.</p>
                </div>
                <button @click="editModalOpen = false" type="button" class="w-8 h-8 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form :action="'{{ url('admin/organization/members') }}/' + editData.id" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nama Lengkap & Gelar <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" x-model="editData.nama" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">NIP / NIDN</label>
                        <input type="text" name="nip_nidn" x-model="editData.nip_nidn"
                               class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Urutan Hierarki <span class="text-rose-500">*</span></label>
                        <input type="number" name="urutan" x-model="editData.urutan" min="0" required
                               class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Jabatan Struktural <span class="text-rose-500">*</span></label>
                    <input type="text" name="jabatan" x-model="editData.jabatan" required
                           class="w-full h-11 px-4 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Deskripsi Tugas & Tanggung Jawab</label>
                    <textarea name="deskripsi_tugas" x-model="editData.deskripsi_tugas" rows="3"
                              class="w-full p-4 rounded-xl border border-slate-300 text-xs focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] leading-5"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Ganti Foto Profil</label>
                    <div class="flex items-center gap-4">
                        <template x-if="editData.foto_url">
                            <img :src="editData.foto_url" alt="Foto Pengurus" class="w-12 h-12 rounded-full object-cover border border-slate-300 flex-shrink-0">
                        </template>
                        <input type="file" name="foto" accept="image/png,image/jpeg,image/webp"
                               class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer">
                    </div>
                    <p class="text-xs text-slate-400 mt-1 leading-4">Biarkan kosong jika tidak ingin mengubah foto profil.</p>
                </div>

                <div class="pt-2">
                    <label class="inline-flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="status_aktif" value="1" :checked="editData.status_aktif" class="w-4 h-4 rounded text-[#0B2A59] focus:ring-[#0B2A59] border-slate-300">
                        <span class="text-xs font-medium text-slate-700 leading-4">Status Pengurus Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-slate-100">
                    <button @click="editModalOpen = false" type="button" 
                            class="h-11 px-5 rounded-xl text-xs font-semibold text-slate-600 bg-white border border-slate-300 hover:bg-slate-50 leading-4">
                        Batal
                    </button>
                    <button type="submit" 
                            class="h-11 px-6 rounded-xl text-xs font-semibold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all leading-4">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
