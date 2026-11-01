<!-- Official Kemenhub Dark Navy Footer (Strict 4px grid & WCAG AA Contrast) -->
<footer class="bg-[#0B2A59] text-slate-300 border-t border-yellow-500/30 pt-16 pb-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
            
            <!-- Identitas & Kontak Institusi -->
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-12 w-auto object-contain flex-shrink-0">
                    <div>
                        <div class="text-base font-bold text-white leading-6">P3M PKTJ</div>
                        <div class="text-xs text-slate-400 leading-4">Politeknik Keselamatan Transportasi Jalan</div>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-5 max-w-sm">
                    Lembaga pengelola penelitian vokasi keselamatan transportasi, publikasi ilmiah bereputasi, Hak Kekayaan Intelektual (HKI), dan pengabdian kepada masyarakat di bawah Badan Pengembangan SDM Perhubungan, Kementerian Perhubungan Republik Indonesia.
                </p>
                <div class="text-xs text-slate-300 space-y-2 pt-2 leading-4">
                    <div>Jl. Semeru No. 3, Tegal, Jawa Tengah 52125</div>
                    <div>Layanan Email: <a href="mailto:p3m@pktj.ac.id" class="text-yellow-400 hover:underline">p3m@pktj.ac.id</a></div>
                </div>
            </div>

            <!-- Navigasi Cepat Terstruktur -->
            <div class="lg:col-span-3 space-y-3">
                <div class="text-xs font-bold uppercase tracking-wider text-white leading-4">Navigasi Utama</div>
                <ul class="text-xs space-y-2 leading-4">
                    <li><a href="{{ route('profil.sdm') }}" class="hover:text-yellow-400 transition-colors">Sumber Daya Manusia (SDM)</a></li>
                    <li><a href="{{ route('profil.peneliti') }}" class="hover:text-yellow-400 transition-colors">Profil Peneliti & Dosen</a></li>
                    <li><a href="{{ route('profil.visi-misi') }}" class="hover:text-yellow-400 transition-colors">Visi, Misi & Tujuan</a></li>
                    <li><a href="{{ route('profil.rencana-strategis') }}" class="hover:text-yellow-400 transition-colors">Rencana Strategis (Renstra)</a></li>
                    <li><a href="{{ route('profil.roadmap-penelitian') }}" class="hover:text-yellow-400 transition-colors">Roadmap Penelitian Keselamatan</a></li>
                    <li><a href="{{ route('riset.penelitian') }}" class="hover:text-yellow-400 transition-colors">Kegiatan Penelitian Terapan</a></li>
                    <li><a href="{{ route('riset.luaran') }}" class="hover:text-yellow-400 transition-colors">Luaran Riset (Publikasi & HKI)</a></li>
                    <li><a href="{{ route('riset.kerjasama') }}" class="hover:text-yellow-400 transition-colors">Kerjasama Penelitian</a></li>
                    <li><a href="{{ route('pengabdian.pkm') }}" class="hover:text-yellow-400 transition-colors">Pengabdian Kepada Masyarakat</a></li>
                    <li><a href="{{ route('pengabdian.luaran') }}" class="hover:text-yellow-400 transition-colors">Hasil Analisis Luaran PkM</a></li>
                    <li><a href="{{ route('pengabdian.kerjasama') }}" class="hover:text-yellow-400 transition-colors">Kerjasama Pengabdian Masyarakat</a></li>
                    <li><a href="{{ route('layanan.panduan-pedoman') }}" class="hover:text-yellow-400 transition-colors">Panduan & Pedoman Mutu Layanan</a></li>
                    <li><a href="https://ktj.pktj.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">Jurnal Ilmiah PKTJ</a></li>
                    <li class="pt-2 border-t border-slate-700/60">
                        @auth
                            @php
                                $user = auth()->user();
                                $footerDashboardUrl = $user->isAdmin() 
                                    ? route('admin.dashboard') 
                                    : ($user->isReviewer() ? route('reviewer.dashboard') : route('dosen.dashboard'));
                                $footerPortalLabel = $user->isAdmin() 
                                    ? 'Buka Panel Admin SIM P3M' 
                                    : ($user->isReviewer() ? 'Buka Portal Reviewer SIM' : 'Buka Portal Dosen SIM');
                            @endphp
                            <a href="{{ $footerDashboardUrl }}" class="text-yellow-400 font-semibold hover:underline transition-colors flex items-center gap-1.5">
                                <span>{{ $footerPortalLabel }}</span>
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-yellow-400 font-semibold hover:underline transition-colors flex items-center gap-1.5">
                                <span>Masuk ke SIM P3M PKTJ</span>
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>

            <!-- Tautan Terkait Kementerian & Nasional -->
            <div class="lg:col-span-4 space-y-3">
                <div class="text-xs font-bold uppercase tracking-wider text-white leading-4">Tautan Terkait</div>
                <ul class="text-xs space-y-2 leading-4">
                    <li>
                        <a href="https://pktj.ac.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-1.5">
                            <span>Website PKTJ Tegal</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://dephub.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-1.5">
                            <span>Kementerian Perhubungan RI</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://ktj.pktj.ac.id/" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-1.5">
                            <span>Jurnal Ilmiah PKTJ</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </li>
                    <li>
                        <a href="https://sinta.kemdikbud.go.id" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-1.5">
                            <span>SINTA Kemdiktisaintek</span>
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        </a>
                    </li>
                </ul>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="pt-8 border-t border-slate-700/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4 leading-4">
            <div>
                &copy; {{ date('Y') }} P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.
            </div>
            <div class="text-slate-400 text-xs">
                Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ Tegal
            </div>
        </div>

    </div>
</footer>
