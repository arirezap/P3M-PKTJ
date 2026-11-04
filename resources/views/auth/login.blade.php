<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk SIM P3M - Politeknik Keselamatan Transportasi Jalan</title>

    <!-- Favicon / Shortcut Icon (Logo PKTJ) -->
    <link rel="icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logoPKTJ.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logoPKTJ.png') }}">

    <!-- Meta SEO -->
    <meta name="description" content="Halaman masuk Sistem Informasi Manajemen Penelitian dan Pengabdian kepada Masyarakat (SIM P3M) Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal.">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-700 antialiased font-sans min-h-screen flex flex-col justify-between"
      x-data="{
          loginInput: '{{ old('login', '') }}',
          passwordInput: '',
          showPassword: false,
          fillAccount(loginVal, passVal) {
              this.loginInput = loginVal;
              this.passwordInput = passVal;
          }
      }">

    <!-- Top Mini Bar (Identitas Kementerian Perhubungan) -->
    <div class="bg-[#0B2A59] text-slate-200 text-xs py-2 px-4 sm:px-6 lg:px-8 border-b border-yellow-500/30 leading-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="font-medium tracking-wide">Kementerian Perhubungan RI</span>
                <span class="text-slate-400 hidden sm:inline">|</span>
                <span class="text-slate-300 hidden sm:inline">BPSDM Perhubungan</span>
            </div>
            <a href="/" class="text-yellow-400 hover:underline inline-flex items-center gap-2 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                <span>Kembali ke Portal Publik</span>
            </a>
        </div>
    </div>

    <!-- Main Container -->
    <main class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-6">

            <!-- Card Utama Formulir Login -->
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-6 sm:p-8 space-y-6">
                
                <!-- Identitas Kampus & Lembaga -->
                <div class="text-center space-y-3">
                    <a href="/" class="inline-flex justify-center focus:outline-none">
                        <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-16 w-auto object-contain mx-auto">
                    </a>
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-[#0B2A59] tracking-tight leading-8">
                            SIM P3M PKTJ
                        </h1>
                        <p class="text-xs text-slate-500 mt-1 leading-4">
                            Sistem Informasi Manajemen Penelitian & Pengabdian Masyarakat
                        </p>
                    </div>
                </div>

                <!-- Notifikasi Status / Pesan -->
                @if (session('status'))
                    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 leading-5">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Notifikasi Kesalahan Validasi -->
                @if ($errors->any())
                    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-800 space-y-1 leading-5">
                        <div class="font-semibold">Perhatian:</div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Formulir Masuk -->
                <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                    @csrf

                    <!-- Input Nama Pengguna (Email atau NIDN/NIP) -->
                    <div>
                        <label for="login" class="block text-xs font-semibold text-slate-700 mb-2 leading-4">
                            Nama Pengguna <span class="text-slate-400 font-normal">(Email atau NIDN / NIP)</span>
                        </label>
                        <div class="relative">
                            <input id="login" 
                                   name="login" 
                                   type="text" 
                                   x-model="loginInput"
                                   required 
                                   autofocus
                                   placeholder="nama@pktj.ac.id atau 10 digit NIDN"
                                   class="w-full h-12 px-4 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-colors leading-5">
                        </div>
                    </div>

                    <!-- Input Kata Sandi -->
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label for="password" class="block text-xs font-semibold text-slate-700 leading-4">
                                Kata Sandi
                            </label>
                            <button type="button" 
                                    @click="showPassword = !showPassword" 
                                    class="text-xs text-[#0B2A59] hover:underline focus:outline-none leading-4">
                                <span x-text="showPassword ? 'Sembunyikan' : 'Tampilkan'"></span>
                            </button>
                        </div>
                        <div class="relative">
                            <input id="password" 
                                   name="password" 
                                   :type="showPassword ? 'text' : 'password'" 
                                   x-model="passwordInput"
                                   required 
                                   placeholder="Masukkan kata sandi akun Anda"
                                   class="w-full h-12 px-4 rounded-xl border border-slate-300 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0B2A59] focus:border-[#0B2A59] transition-colors leading-5">
                        </div>
                    </div>

                    <!-- Pilihan Ingat Saya -->
                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" 
                                   name="remember" 
                                   value="1" 
                                   class="w-4 h-4 text-[#0B2A59] border-slate-300 rounded focus:ring-[#0B2A59]">
                            <span class="text-xs text-slate-600 leading-4">Ingat Saya di Perangkat Ini</span>
                        </label>
                    </div>

                    <!-- Tombol Masuk Utama (Touch target h-12 = 48px, Tactile Feedback) -->
                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full h-12 bg-[#0B2A59] hover:bg-blue-900 active:scale-[0.98] text-white text-sm font-semibold rounded-xl transition-all duration-150 shadow-sm hover:shadow focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0B2A59] flex items-center justify-center gap-2 leading-5">
                            <span>Masuk ke SIM P3M</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <!-- Alat Bantu Masuk Cepat untuk Pengujian (Tester Helper) -->
                <div class="pt-4 border-t border-slate-100 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-slate-600 leading-4">Pintasan Akun Uji Coba:</span>
                        <span class="text-[10px] text-slate-400 leading-3">Klik untuk mengisi otomatis</span>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <button type="button" 
                                @click="fillAccount('admin@pktj.ac.id', 'password')"
                                class="h-11 px-2 rounded-lg border border-slate-200 hover:border-[#0B2A59] hover:bg-slate-50 text-xs font-medium text-slate-700 transition-colors flex flex-col items-center justify-center leading-4">
                            <span class="font-bold text-[#0B2A59]">Admin</span>
                            <span class="text-slate-500 text-[10px] leading-3">P3M</span>
                        </button>
                        <button type="button" 
                                @click="fillAccount('dosen@pktj.ac.id', 'password')"
                                class="h-11 px-2 rounded-lg border border-slate-200 hover:border-[#0B2A59] hover:bg-slate-50 text-xs font-medium text-slate-700 transition-colors flex flex-col items-center justify-center leading-4">
                            <span class="font-bold text-[#0B2A59]">Dosen</span>
                            <span class="text-slate-500 text-[10px] leading-3">Pengusul</span>
                        </button>
                        <button type="button" 
                                @click="fillAccount('reviewer@pktj.ac.id', 'password')"
                                class="h-11 px-2 rounded-lg border border-slate-200 hover:border-[#0B2A59] hover:bg-slate-50 text-xs font-medium text-slate-700 transition-colors flex flex-col items-center justify-center leading-4">
                            <span class="font-bold text-[#0B2A59]">Reviewer</span>
                            <span class="text-slate-500 text-[10px] leading-3">Penilai</span>
                        </button>
                    </div>
                </div>

            </div>

            <!-- Catatan Bantuan Akses -->
            <div class="text-center text-xs text-slate-500 space-y-1 leading-4">
                <p>Mengalami kendala saat masuk akun? Hubungi Pengelola P3M PKTJ:</p>
                <p>Email: <a href="mailto:p3m@pktj.ac.id" class="text-[#0B2A59] font-medium hover:underline">p3m@pktj.ac.id</a> | Kampus Tegal</p>
            </div>

        </div>
    </main>

    <!-- Footer Bawah Hak Cipta -->
    <footer class="py-4 text-center text-xs text-slate-400 border-t border-slate-200 bg-white leading-4">
        &copy; {{ date('Y') }} P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.
    </footer>

</body>
</html>
