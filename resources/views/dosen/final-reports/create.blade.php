@extends('layouts.dashboard')

@section('title', 'Penyampaian Laporan Akhir Kegiatan - ' . $proposal->kode_usulan)
@section('portal_name', 'Portal Dosen & Pengusul')

@section('content')
<div class="space-y-6">

    <!-- Breadcrumb & Header Halaman -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <a href="{{ route('dosen.dashboard') }}" class="hover:text-[#0B2A59] hover:underline">Dasbor Usulan</a>
                <span>/</span>
                <a href="{{ route('dosen.proposals.show', $proposal) }}" class="hover:text-[#0B2A59] hover:underline">{{ $proposal->kode_usulan }}</a>
                <span>/</span>
                <span class="text-slate-700 font-semibold">Laporan Akhir</span>
            </div>
            <div class="flex items-center gap-3 mt-1 flex-wrap">
                <h1 class="text-2xl font-bold text-[#0B2A59] leading-8">Penyampaian Laporan Akhir Kegiatan</h1>
                <span class="px-2.5 py-1 rounded-full text-xs font-semibold capitalize {{ $proposal->jenis === 'penelitian' ? 'bg-blue-50 text-[#0B2A59] border border-blue-200' : 'bg-yellow-50 text-yellow-800 border border-yellow-200' }} leading-4">
                    {{ $proposal->jenis }}
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1 leading-4">Unggah dokumen laporan akhir lengkap, pembukuan realisasi anggaran 100%, dan pemutakhiran bukti luaran.</p>
        </div>

        <div>
            <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-4 rounded-xl text-xs font-semibold text-slate-700 bg-white border border-slate-300 hover:bg-slate-50 transition-colors leading-4">
                Kembali ke Usulan
            </a>
        </div>
    </div>

    <!-- Ringkasan Identitas Kegiatan -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-4 shadow-sm">
        <div class="border-b border-slate-100 pb-3">
            <h2 class="text-xs font-bold uppercase tracking-wider text-slate-600 leading-4">Identitas Usulan Kegiatan</h2>
        </div>
        <div class="space-y-2">
            <span class="text-xs font-semibold text-slate-500 leading-4">Judul Kegiatan:</span>
            <h3 class="text-base font-bold text-slate-900 leading-6">{{ $proposal->judul }}</h3>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-xs pt-2 border-t border-slate-100">
            <div>
                <span class="text-slate-500 block leading-4">Kode Usulan:</span>
                <strong class="text-[#0B2A59] leading-5">{{ $proposal->kode_usulan }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Program Studi Homebase:</span>
                <strong class="text-slate-800 leading-5">{{ $proposal->prodi->kode_prodi }} - {{ $proposal->prodi->nama_prodi }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Tahun Anggaran:</span>
                <strong class="text-slate-800 leading-5">T.A. {{ $proposal->tahun_anggaran }}</strong>
            </div>
            <div>
                <span class="text-slate-500 block leading-4">Total Anggaran Disetujui:</span>
                <strong class="text-emerald-700 leading-5">Rp {{ number_format($proposal->total_anggaran, 0, ',', '.') }}</strong>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="p-5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-xs space-y-2">
            <div class="font-bold flex items-center gap-2 text-sm leading-5">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>Mohon Periksa Kembali Isian Formulir</span>
            </div>
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('dosen.proposals.final-report.store', $proposal) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- ==================== BAGIAN 1: BERKAS LAPORAN AKHIR & RINGKASAN ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian 1</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">Naskah Laporan Akhir & Ringkasan Hasil</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Unggah dokumen laporan akhir lengkap sesuai format panduan penyusunan P3M PKTJ.</p>
            </div>

            <div class="space-y-4">
                <!-- Unggah Berkas PDF -->
                <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2">
                    <label class="block text-xs font-bold text-slate-800 leading-4">
                        Berkas Dokumen Laporan Akhir Lengkap (PDF) <span class="text-rose-500">*</span>
                    </label>
                    <p class="text-xs text-slate-500 leading-4">Format berkas PDF, ukuran maksimal 20 MB. Memuat halaman pengesahan, ringkasan, metodologi, hasil pembahasan, dan kesimpulan.</p>
                    <input type="file" name="file_laporan_akhir" required accept=".pdf" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
                </div>

                <!-- Ringkasan Hasil Akhir -->
                <div class="space-y-1.5 text-xs">
                    <label for="ringkasan_hasil" class="font-bold text-slate-800 leading-4 block">
                        Ringkasan Hasil Kegiatan / Abstrak Akhir
                    </label>
                    <p class="text-slate-500 leading-4">Uraian ringkas temuan utama penelitian atau dampak penerapan pengabdian di masyarakat (maksimal 500 kata).</p>
                    <textarea id="ringkasan_hasil" name="ringkasan_hasil" rows="4" class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Tuliskan intisari capaian dan kesimpulan riset...">{{ old('ringkasan_hasil') }}</textarea>
                </div>

                <!-- Perubahan Anggota Tim Jika Ada -->
                <div class="space-y-1.5 text-xs">
                    <label for="perubahan_anggota" class="font-bold text-slate-800 leading-4 block">
                        Perubahan Susunan Anggota Peneliti (Bila Ada)
                    </label>
                    <p class="text-slate-500 leading-4">Hanya diisi jika terdapat pergantian atau penambahan anggota dosen/taruna selama pelaksanaan kegiatan berlangsung.</p>
                    <textarea id="perubahan_anggota" name="perubahan_anggota" rows="2" class="w-full rounded-xl border-slate-300 focus:border-[#0B2A59] focus:ring-[#0B2A59] text-xs p-3" placeholder="Kosongkan jika susunan tim tetap sesuai usulan awal...">{{ old('perubahan_anggota') }}</textarea>
                </div>
            </div>
        </div>

        <!-- ==================== BAGIAN 2: REALISASI SERAPAN ANGGARAN 100% ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian 2</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">Pembukuan Realisasi Serapan Anggaran Biaya (100%)</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Isi nominal realisasi belanja dan catatan peruntukan sesuai pos Rencana Anggaran Biaya (RAB) awal.</p>
            </div>

            @if($proposal->budgets->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-slate-700 font-semibold uppercase tracking-wider leading-4">
                                <th class="py-3 px-4">Kategori Belanja</th>
                                <th class="py-3 px-4">Uraian Kebutuhan</th>
                                <th class="py-3 px-4 text-right">Rencana Usulan</th>
                                <th class="py-3 px-4 text-right w-44">Realisasi (Rp)</th>
                                <th class="py-3 px-4 w-56">Catatan Bukti / Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($proposal->budgets as $index => $budget)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="py-3 px-4 font-semibold text-slate-700 capitalize whitespace-nowrap">
                                        <input type="hidden" name="realisasi[{{ $index }}][kategori]" value="{{ $budget->kategori_belanja }}">
                                        {{ str_replace('_', ' ', $budget->kategori_belanja) }}
                                    </td>
                                    <td class="py-3 px-4 text-slate-800">
                                        <input type="hidden" name="realisasi[{{ $index }}][uraian]" value="{{ $budget->uraian }}">
                                        <input type="hidden" name="realisasi[{{ $index }}][anggaran_usulan]" value="{{ $budget->total_harga }}">
                                        {{ $budget->uraian }}
                                    </td>
                                    <td class="py-3 px-4 text-right font-medium text-slate-900 whitespace-nowrap">
                                        Rp {{ number_format($budget->total_harga, 0, ',', '.') }}
                                    </td>
                                    <td class="py-2 px-4 text-right">
                                        <input type="number" name="realisasi[{{ $index }}][realisasi]" value="{{ old('realisasi.' . $index . '.realisasi', $budget->total_harga) }}" min="0" step="1000" class="w-full rounded-lg border-slate-300 text-right text-xs py-1.5 px-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" required>
                                    </td>
                                    <td class="py-2 px-4">
                                        <input type="text" name="realisasi[{{ $index }}][keterangan]" value="{{ old('realisasi.' . $index . '.keterangan', 'Sesuai nota kuitansi') }}" class="w-full rounded-lg border-slate-300 text-xs py-1.5 px-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Keterangan nota/SPJ">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="space-y-3 text-xs">
                    <p class="text-slate-600 leading-4">Rincian pos belanja belum terdata secara otomatis. Silakan masukkan total realisasi anggaran:</p>
                    <div class="w-full max-w-sm">
                        <label class="block font-bold text-slate-800 mb-1 leading-4">Total Serapan Anggaran (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="total_realisasi_anggaran" value="{{ old('total_realisasi_anggaran', $proposal->total_anggaran) }}" min="0" step="1000" required class="w-full rounded-xl border-slate-300 text-xs p-2.5 focus:border-[#0B2A59] focus:ring-[#0B2A59]">
                    </div>
                </div>
            @endif

            <!-- Unggah Berkas SPJ Lengkap -->
            <div class="p-4 rounded-xl border border-slate-200 bg-slate-50 space-y-2 pt-3">
                <label class="block text-xs font-bold text-slate-800 leading-4">
                    Berkas Rekapitulasi SPJ / Bukti Belanja Sah (PDF / ZIP)
                </label>
                <p class="text-xs text-slate-500 leading-4">Lampirkan bundel pindaian kuitansi, nota pembelian bahan, tiket perjalanan, dan daftar hadir/honorarium (maksimal 20 MB).</p>
                <input type="file" name="file_bukti_spj" accept=".pdf,.zip,.rar" class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#0B2A59] file:text-white hover:file:bg-blue-900 cursor-pointer">
            </div>
        </div>

        <!-- ==================== BAGIAN 3: PEMUTAKHIRAN LUARAN DEFINITIF ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian 3</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">Pemutakhiran Luaran Akhir Definitif</h2>
                <p class="text-xs text-slate-500 mt-0.5 leading-4">Isi tautan publikasi naskah terbit, nomor sertifikat HKI, atau dokumentasi purwarupa fisik.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5 text-xs">

                <!-- 1. Jurnal Ilmiah -->
                <div class="p-4 rounded-xl border border-slate-200 space-y-3 bg-slate-50/40">
                    <div class="font-bold text-slate-900 leading-4 flex items-center justify-between">
                        <span>A. Publikasi Artikel Jurnal Ilmiah</span>
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Nama Jurnal & Akreditasi / Indeks:</label>
                        <input type="text" name="luaran[jurnal][nama_jurnal]" value="{{ old('luaran.jurnal.nama_jurnal') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Contoh: Jurnal Keselamatan Transportasi Jalan (Sinta 2)">
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Tautan / Link URL DOI Naskah Terbit:</label>
                        <input type="url" name="luaran[jurnal][doi_url]" value="{{ old('luaran.jurnal.doi_url') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="https://doi.org/10.xxxx/...">
                    </div>
                </div>

                <!-- 2. Hak Kekayaan Intelektual -->
                <div class="p-4 rounded-xl border border-slate-200 space-y-3 bg-slate-50/40">
                    <div class="font-bold text-slate-900 leading-4 flex items-center justify-between">
                        <span>B. Hak Kekayaan Intelektual (HKI)</span>
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Jenis HKI & Judul Ciptaan/Paten:</label>
                        <input type="text" name="luaran[hki][judul_hki]" value="{{ old('luaran.hki.judul_hki') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Contoh: Hak Cipta - Perangkat Lunak Pendeteksi Titik Rawan Laka">
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Nomor Permohonan / Sertifikat DJKI:</label>
                        <input type="text" name="luaran[hki][nomor_hki]" value="{{ old('luaran.hki.nomor_hki') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Contoh: EC00202612345">
                    </div>
                </div>

                <!-- 3. Prosiding Pemakalah -->
                <div class="p-4 rounded-xl border border-slate-200 space-y-3 bg-slate-50/40">
                    <div class="font-bold text-slate-900 leading-4 flex items-center justify-between">
                        <span>C. Prosiding Seminar / Konferensi</span>
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Nama Konferensi & Penyelenggara:</label>
                        <input type="text" name="luaran[prosiding][nama_konferensi]" value="{{ old('luaran.prosiding.nama_konferensi') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Contoh: Seminar Nasional Transportasi Vokasi 2026">
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Tautan Naskah Prosiding / Repositori:</label>
                        <input type="url" name="luaran[prosiding][link_prosiding]" value="{{ old('luaran.prosiding.link_prosiding') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="https://prosiding.pktj.ac.id/...">
                    </div>
                </div>

                <!-- 4. Purwarupa / Rekayasa / Produk -->
                <div class="p-4 rounded-xl border border-slate-200 space-y-3 bg-slate-50/40">
                    <div class="font-bold text-slate-900 leading-4 flex items-center justify-between">
                        <span>D. Purwarupa Fisik / Rekayasa Sistem</span>
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Spesifikasi Singkat & Wujud Hasil:</label>
                        <input type="text" name="luaran[produk][spesifikasi]" value="{{ old('luaran.produk.spesifikasi') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="Contoh: Sensor Ultrasonik Terkalibrasi dengan Layar Display">
                    </div>
                    <div class="space-y-1">
                        <label class="text-slate-600 block">Tautan Dokumentasi Video / Foto Pengujian:</label>
                        <input type="url" name="luaran[produk][link_dokumentasi]" value="{{ old('luaran.produk.link_dokumentasi') }}" class="w-full rounded-lg border-slate-300 text-xs p-2 focus:border-[#0B2A59] focus:ring-[#0B2A59]" placeholder="https://drive.google.com/...">
                    </div>
                </div>

            </div>
        </div>

        <!-- ==================== BAGIAN 4: PERNYATAAN & KONFIRMASI ==================== -->
        <div class="bg-white border border-slate-200 rounded-2xl p-6 sm:p-8 space-y-6 shadow-sm">
            <div class="border-b border-slate-100 pb-4">
                <span class="px-2.5 py-1 rounded bg-[#0B2A59] text-white text-[10px] font-bold tracking-wider uppercase">Bagian 4</span>
                <h2 class="text-base font-bold text-slate-900 mt-2 leading-6">Pernyataan Tanggung Jawab Mutlak</h2>
            </div>

            <div>
                <label class="flex items-start gap-3 p-4 rounded-xl border border-emerald-200 bg-emerald-50/50 cursor-pointer">
                    <input type="checkbox" required name="pernyataan_keaslian" value="1" class="mt-0.5 text-emerald-700 focus:ring-emerald-700 rounded">
                    <span class="text-xs text-slate-800 leading-5">
                        <strong>Pernyataan Pertanggungjawaban:</strong> Saya menyatakan bahwa naskah laporan akhir ini disusun dengan menjunjung tinggi kode etik akademik, bebas dari fabrikasi data dan plagiarisme, serta seluruh pembukuan realisasi belanja 100% didukung dengan bukti pengeluaran sah yang siap diperiksa oleh auditor kelembagaan.
                    </span>
                </label>
            </div>

            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('dosen.proposals.show', $proposal) }}" class="inline-flex items-center justify-center h-10 px-5 rounded-xl text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors leading-4">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center justify-center h-10 px-6 rounded-xl text-xs font-bold text-white bg-[#0B2A59] hover:bg-blue-900 transition-all shadow-sm active:scale-[0.98] leading-4">
                    Kirimkan Laporan Akhir ke P3M
                </button>
            </div>
        </div>

    </form>

</div>
@endsection

