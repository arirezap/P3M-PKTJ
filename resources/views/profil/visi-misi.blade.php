@extends('layouts.public')

@section('title', ($settings['page_title'] ?? 'Visi, Misi & Tujuan P3M') . ' - P3M Politeknik Keselamatan Transportasi Jalan')
@section('meta_description', 'Visi, Misi, dan Tujuan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Keselamatan Transportasi Jalan (PKTJ) Tegal.')

@section('content')
<main class="flex-1">

    <!-- Breadcrumb Navigasi -->
    <nav aria-label="Breadcrumb" class="bg-slate-50 border-b border-slate-200 py-3">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <ol class="flex items-center gap-2 text-xs text-slate-500 leading-4">
                <li>
                    <a href="{{ route('beranda') }}" class="hover:text-[#0B2A59] transition-colors">Beranda</a>
                </li>
                <li class="text-slate-400">/</li>
                <li>
                    <span class="text-slate-600">Profil</span>
                </li>
                <li class="text-slate-400">/</li>
                <li class="font-bold text-[#0B2A59]" aria-current="page">Visi, Misi & Tujuan</li>
            </ol>
        </div>
    </nav>

    <!-- Header & Pengantar Halaman -->
    <section class="py-10 sm:py-12 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            
            <div class="max-w-3xl space-y-3">
                @if(!empty($settings['visi_badge']))
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded bg-blue-50 text-[#0B2A59] text-xs font-bold leading-4 border border-blue-100">
                        <span>{{ $settings['visi_badge'] }}</span>
                    </div>
                @endif

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 tracking-tight leading-8 sm:leading-9 lg:leading-10">
                    {{ $settings['page_title'] ?? 'Visi, Misi & Tujuan P3M' }}
                </h1>

                <div class="w-20 h-1 bg-yellow-500 rounded"></div>

                <p class="text-xs sm:text-sm text-slate-600 leading-5 sm:leading-6">
                    {{ $settings['page_lead'] ?? 'Visi, Misi, dan Tujuan Pusat Penelitian dan Pengabdian kepada Masyarakat Politeknik Keselamatan Transportasi Jalan.' }}
                </p>
            </div>

        </div>
    </section>

    <!-- Bagian 1: Pernyataan Visi P3M -->
    <section class="py-12 sm:py-16 bg-slate-50 border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-[#0B2A59] rounded-2xl p-6 sm:p-10 lg:p-12 text-white shadow-sm space-y-6 relative overflow-hidden">
                <div class="space-y-2">
                    <span class="inline-flex items-center px-3 py-1 rounded bg-white/10 text-yellow-400 text-xs font-bold uppercase tracking-wider leading-4 border border-white/10">
                        Visi Kelembagaan
                    </span>
                    <h2 class="text-xl sm:text-2xl font-bold text-white tracking-tight leading-7 sm:leading-8">
                        {{ $settings['visi_title'] ?? 'Visi P3M Politeknik Keselamatan Transportasi Jalan' }}
                    </h2>
                </div>

                <blockquote class="text-base sm:text-lg lg:text-xl font-medium text-slate-100 leading-7 sm:leading-8 border-l-4 border-yellow-400 pl-4 sm:pl-6 py-1">
                    "{{ $settings['visi_statement'] ?? 'Menjadi pusat rujukan riset terapan dan pengabdian masyarakat unggulan berbasis keselamatan transportasi jalan yang solutif, berdaya saing global, dan berintegritas pada tahun 2031.' }}"
                </blockquote>

                @if(!empty($settings['visi_subtext']))
                    <p class="text-xs sm:text-sm text-slate-300 leading-5 sm:leading-6 pt-2 border-t border-white/10">
                        {{ $settings['visi_subtext'] }}
                    </p>
                @endif
            </div>
        </div>
    </section>

    <!-- Bagian 2: Butir Misi Utama P3M PKTJ -->
    <section class="py-12 sm:py-16 bg-white border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-12">
            
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Pilar Aksi Kelembagaan</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-9">
                    {{ count($misiList) }} Butir Misi Utama P3M PKTJ
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 leading-5">
                    Langkah operasional yang dilaksanakan secara konsisten dalam mentransformasikan visi menjadi capaian nyata akademik dan pengabdian masyarakat.
                </p>
            </div>

            <!-- Grid Butir Misi Dinamis -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 items-stretch">
                @foreach($misiList as $index => $misi)
                    <div class="bg-slate-50 border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 flex flex-col justify-between space-y-4 shadow-sm hover:shadow transition-all duration-200">
                        <div class="space-y-3">
                            <span class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A59] font-extrabold text-sm flex items-center justify-center leading-4">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <p class="text-xs sm:text-sm text-slate-700 leading-5 sm:leading-6">
                                {{ $misi }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

    <!-- Bagian 3: Tujuan Strategis & Sasaran Mutu -->
    <section class="py-12 sm:py-16 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8 sm:space-y-12">
            
            <div class="max-w-3xl space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-yellow-600 leading-4">Target Capaian Mutu</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-[#0B2A59] tracking-tight leading-8 sm:leading-9">
                    Tujuan Strategis & Sasaran Mutu P3M
                </h2>
                <p class="text-xs sm:text-sm text-slate-600 leading-5">
                    {{ $settings['tujuan_lead'] ?? 'Tujuan strategis P3M PKTJ dirumuskan untuk menjamin ketercapaian sasaran mutu kelembagaan dan kontribusi nyata bagi keselamatan lalu lintas nasional.' }}
                </p>
            </div>

            <!-- Grid Butir Sasaran Tujuan Dinamis -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch">
                @foreach($tujuanList as $index => $tujuan)
                    <div class="bg-white border border-slate-200 hover:border-[#0B2A59] rounded-2xl p-6 sm:p-8 space-y-3 shadow-sm hover:shadow transition-all duration-200">
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 rounded bg-blue-50 text-[#0B2A59] text-[11px] font-bold uppercase tracking-wider leading-3">
                                Sasaran {{ $index + 1 }}
                            </span>
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-slate-900 leading-6">
                            {{ $tujuan['title'] }}
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-600 leading-5 sm:leading-6">
                            {{ $tujuan['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>

        </div>
    </section>

</main>
@endsection
