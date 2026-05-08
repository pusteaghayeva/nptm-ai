@extends('layout')

@section('title', 'NPTM AI - Süni Zəka Platforması')

@section('styles')
<style>
    .gradient-btn {
        background: linear-gradient(135deg, #1356A4, #0A2240);
        transition: all 0.3s;
    }
    .gradient-btn:hover {
        background: linear-gradient(135deg, #0A2240, #1356A4);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(19,86,164,0.4);
    }
    .feature-card {
        background: #1e293b;
        border: 1px solid #334155;
        transition: all 0.2s;
    }
    .feature-card:hover {
        border-color: #1356A4;
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(19,86,164,0.2);
    }
    .stat-card {
        background: rgba(255,255,255,0.05);
        border: 1px solid rgba(255,255,255,0.08);
    }
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-12px); }
    }
    .float-anim { animation: float 3s ease-in-out infinite; }
    @keyframes pulse-ring {
        0% { transform: scale(0.95); opacity: 0.5; }
        50% { transform: scale(1.05); opacity: 0.2; }
        100% { transform: scale(0.95); opacity: 0.5; }
    }
    .pulse-ring { animation: pulse-ring 3s ease-in-out infinite; }
</style>
@endsection

@section('content')
<div style="background:#0f172a; min-height:100vh">

    {{-- Navbar --}}
    <nav class="border-b px-6 py-4" style="border-color:rgba(255,255,255,0.06); background:rgba(10,34,64,0.8); backdrop-filter:blur(10px); position:sticky; top:0; z-index:50">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <!-- <img src="/images/logo.png" alt="NPTM" class="w-10 h-10 object-contain" style="filter:brightness(0) invert(1)"> -->

                <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#E8A010">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
    </svg>
</div>
                <div>
                    <div class="font-bold text-white">NPTM AI</div>
                    <div class="text-xs" style="color:#60a5fa">ai.nptm.gov.az</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                @auth
                    <a href="/chat" class="gradient-btn text-white px-5 py-2 rounded-xl font-medium text-sm">
                        Çata keç →
                    </a>
                @else
                    <a href="/login" class="text-sm px-4 py-2 rounded-xl transition"
                       style="color:#94a3b8"
                       onmouseover="this.style.color='#fff'"
                       onmouseout="this.style.color='#94a3b8'">Daxil ol</a>
                    <a href="/register" class="gradient-btn text-white px-5 py-2 rounded-xl font-medium text-sm">
                        Başla →
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Hero --}}
    <div class="max-w-6xl mx-auto px-6 py-20">
        <div class="flex items-center gap-12">

            {{-- Sol tərəf --}}
            <div class="flex-1">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-sm mb-6"
                     style="background:rgba(19,86,164,0.2); color:#60a5fa; border:1px solid rgba(19,86,164,0.3)">
                    <div class="w-2 h-2 rounded-full" style="background:#22c55e"></div>
                    Naxçıvan Poçt və Telekommunikasiya Mərkəzi
                </div>

                <h1 class="text-5xl font-bold text-white mb-5 leading-tight">
                    NPTM
                    <span style="background:linear-gradient(135deg,#E8A010,#F4B942); -webkit-background-clip:text; -webkit-text-fill-color:transparent">
                        Süni Zəka
                    </span>
                    <br>Platforması
                </h1>

                <p class="text-lg mb-8" style="color:#94a3b8; max-width:480px; line-height:1.7">
                    Poçt və telekommunikasiya xidmətləri haqqında suallarınıza
                    anında cavab alın. 24/7 aktiv, 100% Azərbaycan dilində.
                </p>

                <div class="flex gap-4">
                    <a href="/register" class="gradient-btn text-white px-8 py-3.5 rounded-2xl font-semibold">
                        İndi Başla →
                    </a>
                    <a href="/login" class="text-white px-8 py-3.5 rounded-2xl font-semibold transition"
                       style="background:rgba(255,255,255,0.05); border:1px solid rgba(255,255,255,0.1)"
                       onmouseover="this.style.background='rgba(255,255,255,0.1)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.05)'">
                        Daxil ol
                    </a>
                </div>
            </div>

            {{-- Sağ tərəf - Logo --}}
            <div class="flex-shrink-0 relative w-80 h-80 flex items-center justify-center">
                {{-- Dekorativ dairələr --}}
                <div class="absolute w-72 h-72 rounded-full pulse-ring"
                     style="border:2px solid rgba(19,86,164,0.3); background:rgba(19,86,164,0.05)"></div>
                <div class="absolute w-56 h-56 rounded-full"
                     style="border:1px solid rgba(232,160,16,0.2); background:rgba(19,86,164,0.08)"></div>
                {{-- Dekorativ nöqtələr --}}
                <div class="absolute w-3 h-3 rounded-full" style="background:#E8A010; top:20px; right:60px; opacity:0.7"></div>
                <div class="absolute w-2 h-2 rounded-full" style="background:#60a5fa; bottom:30px; left:50px; opacity:0.6"></div>
                <div class="absolute w-2 h-2 rounded-full" style="background:#22c55e; top:60px; left:30px; opacity:0.5"></div>
                {{-- Logo --}}
                <img src="/images/logo.png" alt="NPTM Logo"
                     class="relative w-48 h-48 object-contain float-anim"
                     style="filter:brightness(0) invert(1) sepia(1) saturate(3) hue-rotate(190deg) brightness(1.5)">
            </div>
        </div>
    </div>

    {{-- Stat kartları --}}
    <div class="max-w-6xl mx-auto px-6 pb-16">
        <div class="grid grid-cols-3 gap-5 max-w-2xl mx-auto">
            @foreach([
                ['value'=>'24/7',  'label'=>'Fasiləsiz Xidmət'],
                ['value'=>'100%',  'label'=>'Azərbaycan dili'],
                ['value'=>'≤3s',   'label'=>'Cavab sürəti'],
            ] as $stat)
            <div class="stat-card rounded-2xl py-6 text-center">
                <div class="text-3xl font-bold mb-1" style="color:#E8A010">{{ $stat['value'] }}</div>
                <div class="text-sm" style="color:#64748b">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Xüsusiyyətlər --}}
    <div class="max-w-6xl mx-auto px-6 pb-20">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-white mb-3">Niyə NPTM AI?</h2>
            <p style="color:#64748b">Vətəndaşlara daha sürətli, daha ağıllı xidmət</p>
        </div>

        <div class="grid md:grid-cols-3 gap-5">
            @foreach([
                ['icon'=>'📮', 'title'=>'Poçt Xidmətləri',    'desc'=>'Göndəriş izləmə, tariflər, çatdırılma müddətləri haqqında anında məlumat alın.'],
                ['icon'=>'📡', 'title'=>'Telekommunikasiya',   'desc'=>'İnternet, telefon xidmətləri və tarif planları haqqında suallarınızı soruşun.'],
                ['icon'=>'🏢', 'title'=>'Filial Məlumatları',  'desc'=>'Ən yaxın filialı tapın, iş saatlarını və əlaqə məlumatlarını öyrənin.'],
            ] as $f)
            <div class="feature-card rounded-2xl p-6">
                <div class="text-4xl mb-4">{{ $f['icon'] }}</div>
                <h3 class="font-semibold text-white mb-2 text-lg">{{ $f['title'] }}</h3>
                <p class="text-sm leading-relaxed" style="color:#64748b">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- CTA --}}
    <div class="max-w-6xl mx-auto px-6 pb-20">
<div class="rounded-3xl p-12 text-center" style="background:#1e293b; border:1px solid #334155">
            <h2 class="text-3xl font-bold text-white mb-4">Hazırsınız?</h2>
            <p class="mb-8 text-lg" style="color:rgba(255,255,255,0.7)">
                NPTM AI ilə xidmətlərdən daha rahat istifadə edin
            </p>
            <a href="/register" class="inline-block px-10 py-4 rounded-2xl font-bold text-lg transition"
               style="background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff"
               onmouseover="this.style.background='#F4B942'; this.style.transform='translateY(-2px)'"
               onmouseout="this.style.background='#E8A010'; this.style.transform='translateY(0)'">
                Pulsuz Qeydiyyat →
            </a>
        </div>
    </div>

    {{-- Footer --}}
    <div class="border-t py-8 text-center text-sm" style="border-color:rgba(255,255,255,0.06); color:#475569">
        © {{ date('Y') }} NPTM AI — Naxçıvan Poçt və Telekommunikasiya Mərkəzi
    </div>
</div>
@endsection