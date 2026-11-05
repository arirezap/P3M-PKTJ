@php
    $nav = $navSettings ?? \App\Models\Setting::getNavigationSettings();
@endphp
<!-- Institutional Dark Navy Footer (Strict 4px grid & WCAG AA Contrast) -->
<footer class="bg-[#0B2A59] text-slate-300 border-t border-yellow-500/30 pt-16 pb-12 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-8">
            
            <!-- Identitas & Kontak Institusi -->
            <div class="lg:col-span-5 space-y-4">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('images/logoPKTJ.png') }}" alt="Logo PKTJ" class="h-12 w-auto object-contain flex-shrink-0">
                    <div>
                        <div class="text-base font-bold text-white leading-6">{{ $nav['footer_brand_title'] ?? 'P3M PKTJ' }}</div>
                        <div class="text-xs text-slate-400 leading-4">{{ $nav['footer_brand_subtitle'] ?? 'Politeknik Keselamatan Transportasi Jalan' }}</div>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-5 max-w-sm">
                    {{ $nav['footer_about_text'] ?? 'Lembaga pengelola penelitian vokasi keselamatan transportasi, publikasi ilmiah bereputasi, Hak Kekayaan Intelektual (HKI), dan pengabdian kepada masyarakat di bawah Badan Pengembangan SDM Perhubungan, Kementerian Perhubungan Republik Indonesia.' }}
                </p>
                <div class="text-xs text-slate-300 space-y-2 pt-2 leading-4">
                    <div>{{ $nav['footer_address'] ?? 'Jl. Semeru No. 3, Tegal, Jawa Tengah 52125' }}</div>
                    <div>Layanan Email: <a href="mailto:{{ $nav['footer_email'] ?? 'p3m@pktj.ac.id' }}" class="text-yellow-400 hover:underline">{{ $nav['footer_email'] ?? 'p3m@pktj.ac.id' }}</a></div>
                    @if(!empty($nav['footer_phone']))
                        <div>Telepon: <span class="text-slate-200">{{ $nav['footer_phone'] }}</span></div>
                    @endif
                </div>
            </div>

            <!-- Navigasi Cepat Terstruktur -->
            <div class="lg:col-span-3 space-y-3">
                <div class="text-xs font-bold uppercase tracking-wider text-white leading-4">{{ $nav['footer_nav_title'] ?? 'Navigasi Utama' }}</div>
                <ul class="text-xs space-y-2 leading-4">
                    <li><a href="{{ route('profil.rencana-strategis') }}" class="hover:text-yellow-400 transition-colors">Rencana Strategis (Renstra)</a></li>
                    <li><a href="{{ route('profil.roadmap-penelitian') }}" class="hover:text-yellow-400 transition-colors">Roadmap Penelitian Keselamatan</a></li>
                    <li><a href="{{ route('profil.visi-misi') }}" class="hover:text-yellow-400 transition-colors">Visi, Misi & Tujuan</a></li>
                    <li><a href="{{ route('profil.peneliti') }}" class="hover:text-yellow-400 transition-colors">Profil Peneliti & Dosen</a></li>
                    <li><a href="{{ route('profil.sdm') }}" class="hover:text-yellow-400 transition-colors">Struktur Organisasi (SDM)</a></li>
                    <li><a href="{{ route('riset.penelitian') }}" class="hover:text-yellow-400 transition-colors">Kegiatan Penelitian Terapan</a></li>
                    <li><a href="{{ route('riset.luaran') }}" class="hover:text-yellow-400 transition-colors">Luaran Riset (Publikasi & HKI)</a></li>
                    <li><a href="{{ route('riset.kerjasama') }}" class="hover:text-yellow-400 transition-colors">Kerjasama Penelitian</a></li>
                    <li><a href="{{ route('pengabdian.pkm') }}" class="hover:text-yellow-400 transition-colors">Pengabdian Kepada Masyarakat</a></li>
                    <li><a href="{{ route('pengabdian.luaran') }}" class="hover:text-yellow-400 transition-colors">Hasil Analisis Luaran PkM</a></li>
                    <li><a href="{{ route('pengabdian.kerjasama') }}" class="hover:text-yellow-400 transition-colors">Kerjasama Pengabdian Masyarakat</a></li>
                    <li><a href="{{ route('layanan.panduan-pedoman') }}" class="hover:text-yellow-400 transition-colors">Panduan dan Pedoman</a></li>
                    <li><a href="{{ route('layanan.sop') }}" class="hover:text-yellow-400 transition-colors">Standar Operasional Prosedur (SOP)</a></li>
                    <li><a href="{{ $nav['navbar_jurnal_url'] ?? 'https://ktj.pktj.ac.id/' }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors">{{ $nav['footer_link_3_label'] ?? 'Jurnal Ilmiah PKTJ' }}</a></li>

                </ul>
            </div>

            <!-- Tautan Terkait Kementerian & Nasional -->
            <div class="lg:col-span-4 space-y-3">
                <div class="text-xs font-bold uppercase tracking-wider text-white leading-4">{{ $nav['footer_links_title'] ?? 'Tautan Terkait' }}</div>
                <ul class="text-xs space-y-2 leading-4">
                    @if(!empty($nav['footer_link_1_label']) && !empty($nav['footer_link_1_url']))
                        <li>
                            <a href="{{ $nav['footer_link_1_url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-2">
                                <span>{{ $nav['footer_link_1_label'] }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endif
                    @if(!empty($nav['footer_link_2_label']) && !empty($nav['footer_link_2_url']))
                        <li>
                            <a href="{{ $nav['footer_link_2_url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-2">
                                <span>{{ $nav['footer_link_2_label'] }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endif
                    @if(!empty($nav['footer_link_3_label']) && !empty($nav['footer_link_3_url']))
                        <li>
                            <a href="{{ $nav['footer_link_3_url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-2">
                                <span>{{ $nav['footer_link_3_label'] }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endif
                    @if(!empty($nav['footer_link_4_label']) && !empty($nav['footer_link_4_url']))
                        <li>
                            <a href="{{ $nav['footer_link_4_url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-2">
                                <span>{{ $nav['footer_link_4_label'] }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endif
                    @if(!empty($nav['footer_link_5_label']) && !empty($nav['footer_link_5_url']))
                        <li>
                            <a href="{{ $nav['footer_link_5_url'] }}" target="_blank" rel="noopener noreferrer" class="hover:text-yellow-400 transition-colors flex items-center gap-2">
                                <span>{{ $nav['footer_link_5_label'] }}</span>
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Bottom Copyright -->
        <div class="pt-8 border-t border-slate-700/80 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-400 gap-4 leading-4">
            <div>
                {!! str_replace('{Y}', date('Y'), $nav['footer_copyright_text'] ?? ('&copy; ' . date('Y') . ' P3M Politeknik Keselamatan Transportasi Jalan (PKTJ). Hak Cipta Dilindungi.')) !!}
            </div>
            <div class="text-slate-400 text-xs">
                {{ $nav['footer_copyright_sub'] ?? 'Pusat Penelitian dan Pengabdian kepada Masyarakat PKTJ Tegal' }}
            </div>
        </div>

    </div>
</footer>
