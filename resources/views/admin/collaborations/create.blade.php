@extends('layouts.admin')

@section('title', 'Tambah Data Kerjasama Penelitian')
@section('breadcrumb', 'CMS Portal Publik / Kerjasama Riset / Tambah Data')

@section('content')
<div class="max-w-4xl space-y-6">
    
    <!-- Header -->
    <div class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-[#0B2A59] leading-7">Tambah Data Kerjasama Penelitian</h1>
            <p class="text-xs text-slate-500 mt-1 leading-4">Masukkan data kemitraan riset baru beserta nomor perjanjian dan berkas dokumen pendukung.</p>
        </div>
        <a href="{{ route('admin.collaborations.index') }}" class="h-10 px-4 rounded-xl border border-slate-200 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center transition-colors">
            Kembali
        </a>
    </div>

    <!-- Error Validation Alert -->
    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1">
            <div class="font-bold">Mohon periksa kembali isian formulir:</div>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulir Tambah Data Kerjasama -->
    <form method="POST" action="{{ route('admin.collaborations.store') }}" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-2xl p-6 shadow-sm space-y-6">
        @csrf

        <div class="space-y-4">
            <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-2">Identitas Mitra & Topik Kerjasama</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nama Mitra / Instansi Kerjasama <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama_mitra" value="{{ old('nama_mitra') }}" required placeholder="Contoh: Korps Lalu Lintas (Korlantas) Polri" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Judul / Topik Kegiatan Kerjasama Penelitian
                    </label>
                    <input type="text" name="judul_kerjasama" value="{{ old('judul_kerjasama') }}" placeholder="Contoh: Pemetaan Titik Rawan Laka Lantas (Black Spot) Jalur Pantura" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Kategori Mitra <span class="text-rose-500">*</span>
                    </label>
                    <select name="kategori_mitra" required class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                        <option value="">-- Pilih Kategori Mitra --</option>
                        <option value="pemerintah" {{ old('kategori_mitra') === 'pemerintah' ? 'selected' : '' }}>Instansi Pemerintah (Kementerian / Lembaga / Dishub)</option>
                        <option value="bumn" {{ old('kategori_mitra') === 'bumn' ? 'selected' : '' }}>BUMN / BUMD Transportasi</option>
                        <option value="industri" {{ old('kategori_mitra', 'industri') === 'industri' ? 'selected' : '' }}>Industri & Manufaktur Otomotif</option>
                        <option value="perguruan_tinggi" {{ old('kategori_mitra') === 'perguruan_tinggi' ? 'selected' : '' }}>Perguruan Tinggi / Universitas</option>
                        <option value="lainnya" {{ old('kategori_mitra') === 'lainnya' ? 'selected' : '' }}>Komunitas & Desa Binaan / Asosiasi</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Keterkaitan Program Studi PKTJ
                    </label>
                    <select name="prodi_id" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                        <option value="">-- Lintas Prodi / Institusi PKTJ --</option>
                        @foreach ($prodis as $prodi)
                            <option value="{{ $prodi->id }}" {{ old('prodi_id') == $prodi->id ? 'selected' : '' }}>
                                {{ $prodi->kode_prodi }} - {{ $prodi->nama_prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Klasifikasi Kegiatan <span class="text-rose-500">*</span>
                    </label>
                    <select name="jenis_kegiatan" required class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                        <option value="penelitian" {{ old('jenis_kegiatan', 'penelitian') === 'penelitian' ? 'selected' : '' }}>Penelitian Terapan</option>
                        <option value="keduanya" {{ old('jenis_kegiatan') === 'keduanya' ? 'selected' : '' }}>Penelitian & Pengabdian (Keduanya)</option>
                        <option value="pengabdian" {{ old('jenis_kegiatan') === 'pengabdian' ? 'selected' : '' }}>Pengabdian kepada Masyarakat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Status Kerjasama <span class="text-rose-500">*</span>
                    </label>
                    <select name="status_kerjasama" required class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                        <option value="aktif" {{ old('status_kerjasama', 'aktif') === 'aktif' ? 'selected' : '' }}>Kerjasama Aktif Berjalan</option>
                        <option value="selesai" {{ old('status_kerjasama') === 'selesai' ? 'selected' : '' }}>Selesai / Terarsip</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <h2 class="text-sm font-bold text-[#0B2A59] border-b border-slate-100 pb-2">Legalitas & Periode Kerjasama</h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Nomor MoU / PKS / Perjanjian
                    </label>
                    <input type="text" name="nomor_mou_pks" value="{{ old('nomor_mou_pks') }}" placeholder="Contoh: MoU/08/KORLANTAS-PKTJ/2026" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tahun Pelaksanaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="tahun" value="{{ old('tahun', date('Y')) }}" required min="2020" max="2035" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tanggal Mulai
                    </label>
                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Tanggal Berakhir (Masa Berlaku)
                    </label>
                    <input type="date" name="tanggal_berakhir" value="{{ old('tanggal_berakhir') }}" class="w-full h-11 px-3 border border-slate-300 rounded-lg text-xs leading-4 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                        Unggah Berkas Dokumen MoU / PKS (PDF)
                    </label>
                    <input type="file" name="file_dokumen" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#0B2A59] hover:file:bg-blue-100 border border-slate-300 rounded-lg h-11 pt-1.5 px-3">
                    <span class="text-[11px] text-slate-400 mt-1 block">Format file wajib PDF, ukuran maksimal 10 MB.</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1 leading-4">
                    Deskripsi Ruang Lingkup & Kemanfaatan Kerjasama
                </label>
                <textarea name="deskripsi" rows="4" placeholder="Uraikan ruang lingkup kerjasama, output riset yang ditargetkan, dan dampak bagi keselamatan transportasi..." class="w-full p-3 border border-slate-300 rounded-lg text-xs leading-5 focus:ring-2 focus:ring-[#0B2A59] focus:outline-none">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-3">
            <a href="{{ route('admin.collaborations.index') }}" class="h-11 px-5 rounded-xl border border-slate-300 text-xs font-semibold text-slate-700 hover:bg-slate-50 flex items-center transition-colors">
                Batal
            </a>
            <button type="submit" class="h-11 px-6 rounded-xl bg-[#0B2A59] hover:bg-blue-900 text-white text-xs font-semibold shadow-sm transition-all active:scale-[0.98]">
                Simpan Data Kerjasama
            </button>
        </div>
    </form>

</div>
@endsection
