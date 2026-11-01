@extends('layouts.dashboard')

@section('title', 'Lembar Penilaian Usulan: ' . $review->proposal->kode_usulan)
@section('portal_name', 'Portal Reviewer & Penilai')

@section('content')
<div class="space-y-6">

    <!-- Navigasi Kembali & Breadcrumb -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <a href="{{ route('reviewer.dashboard') }}" class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 hover:text-[#0B2A59] transition-colors leading-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Beranda Penugasan</span>
        </a>

        <div class="flex items-center gap-2">
            <span class="text-xs text-slate-400">Kode Usulan:</span>
            <span class="text-xs font-bold text-[#0B2A59] px-2.5 py-1 bg-blue-50 border border-blue-200 rounded-lg">
                {{ $review->proposal->kode_usulan }}
            </span>
        </div>
    </div>

    <!-- Banner Status Penilaian -->
    @if($review->status_review === 'selesai')
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-emerald-950 leading-5">Penilaian Telah Dikirimkan ke P3M</h2>
                    <p class="text-xs text-emerald-800 mt-0.5 leading-4">
                        Diserahkan pada {{ $review->tanggal_review ? $review->tanggal_review->translatedFormat('d F Y, H:i') : '-' }} WIB dengan rekomendasi: 
                        <strong class="uppercase font-extrabold text-emerald-900">{{ str_replace('_', ' ', $review->rekomendasi) }}</strong>
                    </p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <span class="block text-[11px] font-semibold text-emerald-700 uppercase tracking-wider leading-3">Total Skor Akhir</span>
                    <span class="text-2xl font-black text-emerald-950 leading-7">{{ number_format($review->total_skor, 1) }} / 100</span>
                </div>
            </div>
        </div>
    @else
        <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-amber-950 leading-5">Usulan Memerlukan Evaluasi Penilaian</h2>
                <p class="text-xs text-amber-800 mt-0.5 leading-4">
                    Mohon cermati dokumen proposal, susunan tim, dan kewajaran anggaran (RAB) sebelum mengisi rubrik penilaian berbobot di bawah ini.
                </p>
            </div>
        </div>
    @endif

    <!-- Bagian 1: Detail Ringkasan Usulan Proposal -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 pb-6 border-b border-slate-100">
            <div class="space-y-2">
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-blue-100 text-blue-800">
                        {{ $review->proposal->jenis === 'penelitian' ? 'Penelitian Keselamatan Transportasi' : 'Pengabdian kepada Masyarakat' }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-slate-100 text-slate-700">
                        Tahun Anggaran {{ $review->proposal->tahun_anggaran }}
                    </span>
                    <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800">
                        {{ $review->proposal->sumber_dana ?? 'DIPA PKTJ' }}
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-bold text-[#0B2A59] leading-7 sm:leading-8">
                    {{ $review->proposal->judul }}
                </h1>
                <p class="text-xs text-slate-500 leading-4">
                    Skema Pendanaan: <strong class="text-slate-700">{{ $review->proposal->skema }}</strong>
                </p>
            </div>

            <!-- Berkas Unduhan PDF -->
            <div class="flex flex-col sm:flex-row md:flex-col gap-2 flex-shrink-0">
                @if($review->proposal->file_proposal)
                    <a href="{{ asset('storage/' . $review->proposal->file_proposal) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Unduh Berkas Proposal PDF</span>
                    </a>
                @else
                    <span class="inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-slate-100 text-slate-400 rounded-xl text-xs font-medium min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Berkas Proposal Belum Diunggah</span>
                    </span>
                @endif

                @if($review->proposal->file_revisi)
                    <a href="{{ asset('storage/' . $review->proposal->file_revisi) }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors min-h-[44px]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        <span>Unduh Berkas Revisi PDF</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Identitas Ketua & Program Studi -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 p-4 bg-slate-50 border border-slate-100 rounded-xl text-xs leading-4">
            <div>
                <span class="block text-slate-400 font-medium">Ketua Pengusul:</span>
                <strong class="text-slate-800 text-sm mt-0.5 block leading-5">{{ $review->proposal->ketua->name }}</strong>
                <span class="text-slate-500">NIDN/NIP: {{ $review->proposal->ketua->nidn_nip ?? '-' }}</span>
            </div>
            <div>
                <span class="block text-slate-400 font-medium">Program Studi:</span>
                <strong class="text-slate-800 text-sm mt-0.5 block leading-5">{{ $review->proposal->prodi->nama_prodi }}</strong>
                <span class="text-slate-500">Jenjang: {{ $review->proposal->prodi->jenjang }} ({{ $review->proposal->prodi->kode_prodi }})</span>
            </div>
            <div>
                <span class="block text-slate-400 font-medium">Total Anggaran (RAB):</span>
                <strong class="text-[#0B2A59] text-base mt-0.5 block leading-6">
                    Rp {{ number_format($review->proposal->total_anggaran, 0, ',', '.') }}
                </strong>
                <span class="text-slate-500">{{ $review->proposal->budgets->count() }} Item Belanja Terdata</span>
            </div>
        </div>

        <!-- Ringkasan Abstrak -->
        <div class="space-y-2">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">Ringkasan Eksekutif / Abstrak</h2>
            <div class="p-4 bg-white border border-slate-200 rounded-xl text-xs leading-6 text-slate-700 text-justify">
                {{ $review->proposal->abstrak ?? 'Abstrak tidak disertakan oleh pengusul.' }}
            </div>
        </div>
    </div>

    <!-- Bagian 2: Informasi Tim Pengusul & Rincian Anggaran Biaya (RAB) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <!-- Tabel Tim Pengusul -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#0B2A59] leading-5">Susunan Tim Pengusul</h2>
                <span class="text-xs text-slate-400 leading-4">{{ $review->proposal->members->count() + 1 }} Personel</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                            <th class="py-2.5 px-3">Nama Anggota</th>
                            <th class="py-2.5 px-3">Peran Tim</th>
                            <th class="py-2.5 px-3">Tugas Spesifik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <tr class="bg-blue-50/50">
                            <td class="py-2.5 px-3 font-semibold text-slate-900">
                                {{ $review->proposal->ketua->name }}
                                <span class="block text-[11px] font-normal text-slate-500">NIDN: {{ $review->proposal->ketua->nidn_nip ?? '-' }}</span>
                            </td>
                            <td class="py-2.5 px-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Ketua Pengusul</span>
                            </td>
                            <td class="py-2.5 px-3 text-slate-600">Penanggung Jawab Utama Riset</td>
                        </tr>
                        @forelse($review->proposal->members as $member)
                            <tr>
                                <td class="py-2.5 px-3 font-medium text-slate-800">
                                    {{ $member->nama }}
                                    <span class="block text-[11px] text-slate-400">ID/NIM: {{ $member->nidn_nim ?? '-' }}</span>
                                </td>
                                <td class="py-2.5 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold {{ $member->peran === 'mahasiswa' ? 'bg-amber-100 text-amber-800' : 'bg-slate-100 text-slate-700' }}">
                                        {{ $member->peran === 'mahasiswa' ? 'Taruna / Mahasiswa' : 'Dosen Anggota' }}
                                    </span>
                                </td>
                                <td class="py-2.5 px-3 text-slate-600">{{ $member->tugas ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="py-3 px-3 text-center text-slate-400">Tidak ada anggota tim tambahan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tabel Rincian Anggaran Biaya (RAB) -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-[#0B2A59] leading-5">Rincian Anggaran Biaya (RAB)</h2>
                <span class="text-xs font-bold text-[#0B2A59] leading-4">Total: Rp {{ number_format($review->proposal->total_anggaran, 0, ',', '.') }}</span>
            </div>

            <div class="overflow-x-auto max-h-80 overflow-y-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead class="sticky top-0 bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                        <tr>
                            <th class="py-2.5 px-3">Kategori & Uraian</th>
                            <th class="py-2.5 px-3 text-center">Vol</th>
                            <th class="py-2.5 px-3 text-right">Harga</th>
                            <th class="py-2.5 px-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($review->proposal->budgets as $budget)
                            <tr>
                                <td class="py-2.5 px-3">
                                    <span class="font-medium text-slate-900 block">{{ $budget->uraian }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase">{{ str_replace('_', ' ', $budget->kategori_belanja) }}</span>
                                </td>
                                <td class="py-2.5 px-3 text-center text-slate-600">{{ $budget->volume }} {{ $budget->satuan }}</td>
                                <td class="py-2.5 px-3 text-right text-slate-600">Rp {{ number_format($budget->harga_satuan, 0, ',', '.') }}</td>
                                <td class="py-2.5 px-3 text-right font-semibold text-slate-900">Rp {{ number_format($budget->total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-3 px-3 text-center text-slate-400">Rincian RAB belum diinput oleh pengusul.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Bagian 3: Formulir Rubrik Penilaian Berstandar PKTJ -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 shadow-sm space-y-6">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-amber-700 leading-4">Lembar Evaluasi Substansi Riset Terapan</span>
            <h2 class="text-xl font-bold text-[#0B2A59] leading-7 mt-0.5">Rubrik Penilaian Usulan & Penetapan Rekomendasi</h2>
            <p class="text-xs text-slate-500 mt-1 leading-4">
                Berikan skor penilaian objektif dengan rentang skala 0 – 100 untuk masing-masing kriteria baku PKTJ Tegal. Total skor akhir akan dikalkulasikan secara otomatis berdasarkan bobot persentase.
            </p>
        </div>

        <form method="POST" action="{{ route('reviewer.reviews.update', $review) }}" class="space-y-8" id="rubrikForm">
            @csrf
            @method('PUT')

            <!-- Kriteria 1: Urgensi Masalah -->
            <div class="p-5 border border-slate-200 rounded-xl space-y-3 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold">1</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-5">Urgensi Masalah & Relevansi Keselamatan Transportasi / Solusi Vokasi</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 pl-8 leading-4">
                            Kejelasan latar belakang, keterdesakan isu keselamatan transportasi darat, atau kebutuhan riil mitra masyarakat/industri.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 sm:self-center pl-8 sm:pl-0">
                        <span class="text-xs font-semibold text-slate-500 leading-4">Bobot: <strong>25%</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-8 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nilai Skor (0 - 100):</label>
                        <input type="number" name="skor_urgensi" id="skor_urgensi" min="0" max="100" step="0.5" 
                            value="{{ old('skor_urgensi', $review->skor_urgensi) }}" required
                            placeholder="Contoh: 85"
                            class="w-full h-11 border-slate-300 rounded-lg text-sm px-3 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        @error('skor_urgensi')
                            <p class="text-xs text-rose-600 mt-1 leading-4">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center sm:justify-end">
                        <div class="text-left sm:text-right">
                            <span class="block text-[11px] text-slate-400 font-medium leading-3">Subtotal Terbobot (Maks 25.0)</span>
                            <span class="text-xl font-black text-[#0B2A59] leading-7" id="preview_urgensi">0.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kriteria 2: Kualitas Metodologi -->
            <div class="p-5 border border-slate-200 rounded-xl space-y-3 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold">2</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-5">Kualitas Metodologi, Desain Teknis & Ketercapaian Riset</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 pl-8 leading-4">
                            Ketepatan rancangan metode eksperimental/lapangan, arsitektur prototipe, kepatuhan standar uji, dan kejelasan tahapan kerja.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 sm:self-center pl-8 sm:pl-0">
                        <span class="text-xs font-semibold text-slate-500 leading-4">Bobot: <strong>30%</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-8 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nilai Skor (0 - 100):</label>
                        <input type="number" name="skor_metodologi" id="skor_metodologi" min="0" max="100" step="0.5" 
                            value="{{ old('skor_metodologi', $review->skor_metodologi) }}" required
                            placeholder="Contoh: 80"
                            class="w-full h-11 border-slate-300 rounded-lg text-sm px-3 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        @error('skor_metodologi')
                            <p class="text-xs text-rose-600 mt-1 leading-4">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center sm:justify-end">
                        <div class="text-left sm:text-right">
                            <span class="block text-[11px] text-slate-400 font-medium leading-3">Subtotal Terbobot (Maks 30.0)</span>
                            <span class="text-xl font-black text-[#0B2A59] leading-7" id="preview_metodologi">0.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kriteria 3: Kelayakan RAB -->
            <div class="p-5 border border-slate-200 rounded-xl space-y-3 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold">3</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-5">Kewajaran & Kelayakan Rincian Anggaran Biaya (RAB)</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 pl-8 leading-4">
                            Kesesuaian komponen belanja terhadap Standar Biaya Masukan (SBM), efisiensi biaya survei/bahan habis pakai, dan tidak ada duplikasi.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 sm:self-center pl-8 sm:pl-0">
                        <span class="text-xs font-semibold text-slate-500 leading-4">Bobot: <strong>20%</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-8 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nilai Skor (0 - 100):</label>
                        <input type="number" name="skor_kelayakan_rab" id="skor_kelayakan_rab" min="0" max="100" step="0.5" 
                            value="{{ old('skor_kelayakan_rab', $review->skor_kelayakan_rab) }}" required
                            placeholder="Contoh: 90"
                            class="w-full h-11 border-slate-300 rounded-lg text-sm px-3 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        @error('skor_kelayakan_rab')
                            <p class="text-xs text-rose-600 mt-1 leading-4">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center sm:justify-end">
                        <div class="text-left sm:text-right">
                            <span class="block text-[11px] text-slate-400 font-medium leading-3">Subtotal Terbobot (Maks 20.0)</span>
                            <span class="text-xl font-black text-[#0B2A59] leading-7" id="preview_rab">0.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kriteria 4: Kualitas Target Luaran -->
            <div class="p-5 border border-slate-200 rounded-xl space-y-3 bg-slate-50/50">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-6 h-6 rounded-full bg-[#0B2A59] text-white flex items-center justify-center text-xs font-bold">4</span>
                            <h3 class="text-sm font-bold text-slate-900 leading-5">Kualitas & Ketercapaian Target Luaran Wajib / Tambahan</h3>
                        </div>
                        <p class="text-xs text-slate-500 mt-1 pl-8 leading-4">
                            Komitmen publikasi artikel di jurnal bereputasi SINTA, perolehan Hak Cipta / Paten sederhana, dan luaran produk teknologi terapan.
                        </p>
                    </div>
                    <div class="flex items-center gap-2 sm:self-center pl-8 sm:pl-0">
                        <span class="text-xs font-semibold text-slate-500 leading-4">Bobot: <strong>25%</strong></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pl-8 pt-2">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">Nilai Skor (0 - 100):</label>
                        <input type="number" name="skor_luaran" id="skor_luaran" min="0" max="100" step="0.5" 
                            value="{{ old('skor_luaran', $review->skor_luaran) }}" required
                            placeholder="Contoh: 85"
                            class="w-full h-11 border-slate-300 rounded-lg text-sm px-3 focus:ring-[#0B2A59] focus:border-[#0B2A59]">
                        @error('skor_luaran')
                            <p class="text-xs text-rose-600 mt-1 leading-4">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex items-center sm:justify-end">
                        <div class="text-left sm:text-right">
                            <span class="block text-[11px] text-slate-400 font-medium leading-3">Subtotal Terbobot (Maks 25.0)</span>
                            <span class="text-xl font-black text-[#0B2A59] leading-7" id="preview_luaran">0.0</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rekapitulasi Total Skor Akhir Dinamis -->
            <div class="p-6 bg-gradient-to-r from-slate-900 to-[#0B2A59] text-white rounded-2xl flex flex-col md:flex-row md:items-center justify-between gap-6 shadow-md">
                <div class="space-y-1">
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-300 leading-4">Rekapitulasi Evaluasi PKTJ</span>
                    <h3 class="text-lg font-bold leading-6">Kalkulasi Total Skor Akhir Usulan</h3>
                    <p class="text-xs text-slate-300 leading-4">Perhitungan bobot: Urgensi (25%) + Metodologi (30%) + RAB (20%) + Luaran (25%)</p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="text-right">
                        <span class="block text-xs text-slate-300 leading-4">Kualifikasi:</span>
                        <span class="text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4" id="kualifikasi_badge">
                            Menunggu Input Skor
                        </span>
                    </div>

                    <div class="w-px h-12 bg-white/20"></div>

                    <div class="text-right">
                        <span class="block text-xs text-slate-300 leading-4">Total Skor Akhir:</span>
                        <div class="text-3xl sm:text-4xl font-black text-amber-400 leading-9 sm:leading-10">
                            <span id="grand_total_skor">0.0</span>
                            <span class="text-lg text-slate-300 font-normal">/ 100</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian Rekomendasi & Catatan Evaluasi -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-2">
                
                <!-- Pilihan Rekomendasi -->
                <div class="md:col-span-1 space-y-3">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">
                        Penetapan Rekomendasi:
                    </label>

                    <div class="space-y-2">
                        <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="rekomendasi" value="diterima" 
                                {{ old('rekomendasi', $review->rekomendasi) === 'diterima' ? 'checked' : '' }} required
                                class="mt-0.5 text-emerald-600 focus:ring-emerald-500">
                            <div class="text-xs leading-4">
                                <strong class="text-emerald-900 block font-bold">Diterima (Lolos)</strong>
                                <span class="text-slate-500 text-[11px]">Usulan sangat layak didanai tanpa revisi mayor.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="rekomendasi" value="diterima_dengan_revisi" 
                                {{ old('rekomendasi', $review->rekomendasi) === 'diterima_dengan_revisi' ? 'checked' : '' }} required
                                class="mt-0.5 text-amber-600 focus:ring-amber-500">
                            <div class="text-xs leading-4">
                                <strong class="text-amber-900 block font-bold">Diterima dengan Revisi</strong>
                                <span class="text-slate-500 text-[11px]">Layak didanai setelah pengusul memperbaiki catatan.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3.5 border border-slate-200 rounded-xl cursor-pointer hover:bg-slate-50 transition-colors">
                            <input type="radio" name="rekomendasi" value="ditolak" 
                                {{ old('rekomendasi', $review->rekomendasi) === 'ditolak' ? 'checked' : '' }} required
                                class="mt-0.5 text-rose-600 focus:ring-rose-500">
                            <div class="text-xs leading-4">
                                <strong class="text-rose-900 block font-bold">Ditolak</strong>
                                <span class="text-slate-500 text-[11px]">Belum memenuhi standar mutu atau luaran riset PKTJ.</span>
                            </div>
                        </label>
                    </div>

                    @error('rekomendasi')
                        <p class="text-xs text-rose-600 leading-4">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan Evaluasi Reviewer -->
                <div class="md:col-span-2 space-y-2">
                    <label for="catatan_reviewer" class="block text-xs font-bold uppercase tracking-wider text-slate-700 leading-4">
                        Catatan Evaluasi Kritis & Arahan Penyempurnaan:
                    </label>
                    <textarea name="catatan_reviewer" id="catatan_reviewer" rows="6" required minlength="10"
                        placeholder="Tuliskan catatan evaluasi konstruktif terkait metodologi, kelayakan anggaran, maupun penguatan target luaran bagi pengusul..."
                        class="w-full p-3.5 border-slate-300 rounded-xl text-xs leading-5 focus:ring-[#0B2A59] focus:border-[#0B2A59]">{{ old('catatan_reviewer', $review->catatan_reviewer) }}</textarea>
                    <p class="text-[11px] text-slate-400 leading-4">
                        Catatan ini akan diteruskan ke tim pengusul sebagai umpan balik akademik jika status memerlukan revisi.
                    </p>
                    @error('catatan_reviewer')
                        <p class="text-xs text-rose-600 leading-4">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <!-- Tombol Aksi Simpan & Kirim -->
            <div class="pt-6 border-t border-slate-200 flex flex-col sm:flex-row sm:items-center justify-end gap-3">
                <a href="{{ route('reviewer.dashboard') }}" class="px-5 py-2.5 border border-slate-300 text-slate-700 rounded-xl text-xs font-semibold hover:bg-slate-50 transition-colors text-center min-h-[44px] flex items-center justify-center">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2.5 bg-[#0B2A59] hover:bg-blue-900 text-white rounded-xl text-xs font-semibold shadow-sm transition-colors text-center min-h-[44px] flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>Simpan & Kirim Penilaian ke P3M</span>
                </button>
            </div>

        </form>
    </div>

</div>

<!-- JavaScript Kalkulasi Dinamis Rubrik Nilai -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const elUrgensi = document.getElementById('skor_urgensi');
    const elMetodologi = document.getElementById('skor_metodologi');
    const elRab = document.getElementById('skor_kelayakan_rab');
    const elLuaran = document.getElementById('skor_luaran');

    const prevUrgensi = document.getElementById('preview_urgensi');
    const prevMetodologi = document.getElementById('preview_metodologi');
    const prevRab = document.getElementById('preview_rab');
    const prevLuaran = document.getElementById('preview_luaran');

    const elTotal = document.getElementById('grand_total_skor');
    const elBadge = document.getElementById('kualifikasi_badge');

    function calculateScore() {
        const u = parseFloat(elUrgensi.value) || 0;
        const m = parseFloat(elMetodologi.value) || 0;
        const r = parseFloat(elRab.value) || 0;
        const l = parseFloat(elLuaran.value) || 0;

        const subU = u * 0.25;
        const subM = m * 0.30;
        const subR = r * 0.20;
        const subL = l * 0.25;

        prevUrgensi.textContent = subU.toFixed(1);
        prevMetodologi.textContent = subM.toFixed(1);
        prevRab.textContent = subR.toFixed(1);
        prevLuaran.textContent = subL.toFixed(1);

        const total = subU + subM + subR + subL;
        elTotal.textContent = total.toFixed(1);

        if (total >= 80) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-emerald-500/20 text-emerald-300 border border-emerald-400/40';
            elBadge.textContent = 'Sangat Layak (Lolos)';
        } else if (total >= 65) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-amber-500/20 text-amber-300 border border-amber-400/40';
            elBadge.textContent = 'Layak Bersyarat (Revisi)';
        } else if (total > 0) {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-rose-500/20 text-rose-300 border border-rose-400/40';
            elBadge.textContent = 'Belum Layak (Ditolak)';
        } else {
            elBadge.className = 'text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider inline-block mt-1 leading-4 bg-slate-700 text-slate-300';
            elBadge.textContent = 'Menunggu Input Skor';
        }
    }

    [elUrgensi, elMetodologi, elRab, elLuaran].forEach(input => {
        input.addEventListener('input', calculateScore);
    });

    calculateScore();
});
</script>
@endsection
