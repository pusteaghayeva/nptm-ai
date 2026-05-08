@extends('layout')

@section('title', 'Daxil ol')

@section('styles')
<style>
    .gradient-btn {
        background: linear-gradient(135deg, #1356A4, #0A2240);
        transition: all 0.3s;
    }
    .gradient-btn:hover {
        background: linear-gradient(135deg, #0A2240, #1356A4);
        transform: translateY(-1px);
        box-shadow: 0 8px 25px rgba(19,86,164,0.4);
    }
    .input-field {
        background: #1e293b;
        border: 1px solid #334155;
        color: #e2e8f0;
        border-radius: 12px;
        padding: 12px 16px;
        width: 100%;
        outline: none;
        transition: border-color 0.2s;
        font-size: 14px;
    }
    .input-field:focus {
        border-color: #1356A4;
    }
    .input-field::placeholder {
        color: #475569;
    }

    @keyframes float1 {
    0%, 100% { transform: translateY(0px) translateX(0px); }
    50% { transform: translateY(-20px) translateX(10px); }
}
@keyframes float2 {
    0%, 100% { transform: translateY(0px) translateX(0px); }
    50% { transform: translateY(15px) translateX(-15px); }
}
@keyframes float3 {
    0%, 100% { transform: translateY(0px) scale(1); }
    50% { transform: translateY(-10px) scale(1.1); }
}
.anim1 { animation: float1 6s ease-in-out infinite; }
.anim2 { animation: float2 8s ease-in-out infinite; }
.anim3 { animation: float3 4s ease-in-out infinite; }
</style>
@endsection

@section('content')
<div class="min-h-screen flex" style="background:#0f172a">

    {{-- Sol tərəf - dekorativ --}}
<div class="hidden lg:flex flex-col items-center justify-center p-12 relative" style="width:55%"         style="background:linear-gradient(135deg,#0A2240,#1356A4)">

        {{-- Dekorativ dairələr --}}
       <div class="absolute top-20 left-20 w-40 h-40 rounded-full anim1"
     style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08)"></div>
<div class="absolute bottom-32 right-16 w-56 h-56 rounded-full anim2"
     style="background:rgba(255,255,255,0.03); border:1px solid rgba(255,255,255,0.08)"></div>
<div class="absolute top-1/2 right-8 w-24 h-24 rounded-full anim3"
     style="background:rgba(232,160,16,0.1); border:1px solid rgba(232,160,16,0.2)"></div>

        {{-- Logo --}}
        <div class="relative text-center">
            <img src="/images/logo.png" alt="NPTM"
                 class="w-40 h-40 object-contain mx-auto mb-8"
                 style="filter:brightness(0) invert(1) sepia(1) saturate(2) hue-rotate(190deg) brightness(1.5)">
            <h2 class="text-3xl font-bold text-white mb-3">NPTM AI</h2>
            <p style="color:rgba(255,255,255,0.6)" class="text-lg">Süni Zəka Platforması</p>
            <p style="color:rgba(255,255,255,0.4)" class="text-sm mt-2">ai.nptm.gov.az</p>
        </div>

    </div>

    {{-- Sağ tərəf - form --}}
    <div class="flex-1 flex items-center justify-center px-8 py-12" style="max-width:480px">
        <div class="w-full">

            {{-- Logo (mobil) --}}
            <div class="flex items-center gap-3 mb-10">
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

            <h1 class="text-2xl font-bold text-white mb-2">Xoş gəlmisiniz!</h1>
            <p class="text-sm mb-8" style="color:#64748b">Hesabınıza daxil olmaq üçün məlumatlarınızı daxil edin</p>

            {{-- Xəta --}}
            @if($errors->any())
            <div class="mb-6 px-4 py-3 rounded-xl text-sm flex items-center gap-2"
                 style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2)">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="input-field" placeholder="email@example.com">
                </div>

                <div class="mb-6">
                    <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Şifrə</label>
                    <input type="password" name="password" required
                        class="input-field" placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between mb-6">
                    <label class="flex items-center gap-2 text-sm cursor-pointer" style="color:#64748b">
                        <input type="checkbox" name="remember" class="rounded" style="accent-color:#1356A4">
                        Məni xatırla
                    </label>
                </div>

                <button type="submit" class="gradient-btn w-full py-3.5 rounded-xl text-white font-semibold text-sm">
                    Daxil ol →
                </button>
            </form>

            <p class="text-center text-sm mt-6" style="color:#475569">
                Hesabınız yoxdur?
                <a href="/register" class="font-medium transition" style="color:#60a5fa"
                   onmouseover="this.style.color='#fff'"
                   onmouseout="this.style.color='#60a5fa'">Qeydiyyatdan keçin</a>
            </p>

            <p class="text-center text-xs mt-8" style="color:#334155">
                © {{ date('Y') }} NPTM AI — Naxçıvan Poçt və Telekommunikasiya Mərkəzi
            </p>
        </div>
    </div>
</div>
@endsection