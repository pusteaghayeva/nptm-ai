@extends('layout')

@section('title', 'Profil')
@section('styles')
    <style>
        .typing-dot {
            animation: typing 1.4s infinite;
        }
        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }
        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
            30% { transform: translateY(-6px); opacity: 1; }
        }
        .message-enter {
            animation: fadeInUp 0.3s ease;
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .sidebar-scroll::-webkit-scrollbar { width: 3px; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 2px; }
        .chat-scroll::-webkit-scrollbar { width: 5px; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #334155; border-radius: 3px; }
        .input-area {
            background: #1e293b;
            border: 1px solid #334155;
            transition: border-color 0.2s;
        }
        .input-area:focus-within {
            border-color: #1356A4;
        }
        .gradient-btn {
            background: linear-gradient(135deg, #1356A4, #0A2240);
            transition: all 0.2s;
        }
        .gradient-btn:hover {
            background: linear-gradient(135deg, #0A2240, #1356A4);
            transform: translateY(-1px);
        }
        .quick-card {
            background: #1e293b;
            border: 1px solid #334155;
            transition: all 0.2s;
            cursor: pointer;
        }
        .quick-card:hover {
            border-color: #1356A4;
            background: #1e3a5f;
            transform: translateY(-2px);
        }
        .conv-item {
            transition: all 0.15s;
            border-radius: 10px;
        }
        .conv-item:hover {
            background: rgba(255,255,255,0.06);
        }
        .conv-item:hover .del-btn {
            opacity: 1;
        }
        .del-btn {
            opacity: 0;
            transition: opacity 0.15s;
        }
        .model-option:hover {
            background: rgba(255,255,255,0.05) !important;
        }

        /* dark/light */
        [data-theme="light"] {
            filter: none;
        }

        /* Əsas arxa fon */
        [data-theme="light"] .flex.h-screen {
            background: #f8fafc !important;
        }

        /* Sol panel */
        /* Sol panel */
        [data-theme="light"] .w-64 {
            background: #fff !important;
        }

        /* Əsas chat sahəsi */
        [data-theme="light"] .flex-1.flex.flex-col {
            background: #f8fafc !important;
        }

        /* Header */
        [data-theme="light"] .border-b {
            background: #ffffff !important;
        }
        /* Header */
        [data-theme="light"] div[style*="border-color:rgba(255,255,255,0.06)"] {
            background: #ffffff !important;
        }

        /* Header mətnləri */
        [data-theme="light"] div[style*="color:#22c55e"] {
            color: #16a34a !important;
        }

        /* Sol panel mətnləri */
        [data-theme="light"] .w-64 .text-white,
        [data-theme="light"] .w-64 a {
            color: #ffffff !important;
            color: #1e293b !important;

        }
        [data-theme="light"] .w-full .px-3 .py-2.5 rounded-xl text-sm font-medium text-white {
                                                       background: rgba(255,255,255,0.1) !important;
                                                   }
        /* Sol panel border */
        [data-theme="light"] .w-64 {
            border-color: rgba(255,255,255,0.1) !important;
        }

        /* Yeni söhbət düyməsi */
        [data-theme="light"] .gradient-btn {
            background: rgba(0,0,0,0.05) !important;
        }
        /* Mesaj kartları - AI */
        [data-theme="light"] div[style*="background:#1e293b"] {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #1e293b !important;
        }
        [data-theme="light"] .shadow-lg{
            background: #E8A010 !important;
        }

        /* Input sahəsi */
        [data-theme="light"] .input-area {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        [data-theme="light"] #messageInput {
            color: #1e293b !important;
        }

        [data-theme="light"] #messageInput::placeholder {
            color: #94a3b8 !important;
        }

        /* Messages area */
        [data-theme="light"] #messages {
            background: #f8fafc !important;
        }

        /* Quick cards */
        [data-theme="light"] .quick-card {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        [data-theme="light"] .quick-card:hover {
            background: #eff6ff !important;
            border-color: #1356A4 !important;
        }

        /* Mətn rəngləri */
        [data-theme="light"] .text-white {
            color: #1e293b !important;
        }

        [data-theme="light"] span[style*="color:#64748b"],
        [data-theme="light"] div[style*="color:#64748b"],
        [data-theme="light"] p[style*="color:#64748b"] {
            color: #64748b !important;
        }

        /* Model dropdown */
        [data-theme="light"] #modelDropdown {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        /* Dropdown model buttonlar */
        [data-theme="light"] .model-option {
            color: #1e293b !important;
        }

        /* Conv items */
        [data-theme="light"] .conv-item:hover {
            background: rgba(0,0,0,0.05) !important;
        }

    .gradient-btn {
        background: linear-gradient(135deg, #1356A4, #0A2240);
        transition: all 0.3s;
    }
    .gradient-btn:hover {
        background: linear-gradient(135deg, #0A2240, #1356A4);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(19,86,164,0.4);
    }
    .card-hover {
        transition: all 0.2s;
    }
    .card-hover:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.08);
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
    .input-field:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

        /* Əsas sahə - sağ tərəf */
        [data-theme="light"] .flex-1.overflow-y-auto {
            background: #f8fafc !important;
        }

        /* Kartlar */
        [data-theme="light"] .rounded-2xl.p-6 {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
        }

        /* Mətn rəngləri */
        [data-theme="light"] h1,
        [data-theme="light"] h2,
        [data-theme="light"] h3 {
            color: #1e293b !important;
        }

        /* Input sahələri */
        [data-theme="light"] .input-field {
            background: #ffffff !important;
            border-color: #e2e8f0 !important;
            color: #1e293b !important;
        }

        /* Arxa fon */
        [data-theme="light"] div[style*="background:#0f172a"] {
            background: #f8fafc !important;
        }

        [data-theme="light"] .rounded-2xl.mb-6.overflow-hidden {
            background: #ffffff !important;
            border: 2px solid #1356A4 !important;
        }

        [data-theme="light"] .rounded-2xl.mb-6.overflow-hidden h2,
        [data-theme="light"] .rounded-2xl.mb-6.overflow-hidden .text-white {
            color: #1e293b !important;
        }

        [data-theme="light"] .rounded-2xl.mb-6.overflow-hidden p {
            color: #64748b !important;
        }

        [data-theme="light"] .rounded-2xl.mb-6.overflow-hidden .text-xs {
            color: #64748b !important;
        }
</style>
@endsection

@section('content')
<div class="flex h-screen overflow-hidden" style="background:#0f172a">

    {{-- Sol panel --}}
    <div class="w-64 flex flex-col" style="background:#0A2240; flex-shrink:0; border-right:1px solid rgba(255,255,255,0.06)">
        <div class="px-4 py-4 border-b" style="border-color:rgba(255,255,255,0.08)">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:#E8A010">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-sm" style="color:#fff">NPTM AI</div>
                    <div class="text-xs" style="color:#60a5fa">ai.nptm.gov.az</div>
                </div>
            </div>
        </div>

        <div class="px-3 pt-3 pb-2">
            <a href="/chat" class="flex items-center gap-2 w-full px-3 py-2.5 rounded-xl text-sm font-medium"
               style="background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff">
                <svg class="w-4 h-4" style="color:#E8A010" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Yeni Söhbət
            </a>
        </div>

        <div class="px-3 py-2">
            <div class="text-xs px-2 py-1 font-medium uppercase tracking-wider mb-1" style="color:#475569">Menyu</div>
            <a href="/chat" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl mb-0.5 text-sm transition"
               style="color:#94a3b8"
               onmouseover="this.style.background='rgba(255,255,255,0.06)'; this.style.color='#fff'"
               onmouseout="this.style.background='transparent'; this.style.color='#94a3b8'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Söhbət
            </a>
            <a href="/profile" class="flex items-center gap-2.5 px-3 py-2.5 rounded-xl mb-0.5 text-sm"
               style="background:rgba(232,160,16,0.15); color:#F4B942; border-left:2px solid #E8A010">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>
        </div>

        <div class="flex-1"></div>

        <div class="px-3 py-3 border-t" style="border-color:rgba(255,255,255,0.08)">
            <div class="flex items-center gap-2.5 px-2 py-2 rounded-xl" style="background:rgba(255,255,255,0.05)">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold"
                     style="background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate" style="color:#fff">{{ Auth::user()->name }}</div>
                    <div class="text-xs truncate" style="color:#64748b">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="flex gap-1 mt-2 px-1">
                @if(Auth::user()->isAdmin())
                <a href="/admin" class="flex-1 text-center text-xs py-1.5 rounded-lg"
                   style="color:#E8A010; background:rgba(232,160,16,0.1)">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button class="w-full text-xs py-1.5 rounded-lg" style="color:#64748b; background:rgba(255,255,255,0.05)">
                        Çıxış
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Əsas sahə --}}
    <div class="flex-1 overflow-y-auto" style="background:#0f172a">

        {{-- Header --}}
        <div class="px-8 py-5 border-b flex items-center justify-between" style="border-color:rgba(255,255,255,0.06)">
            <div>
                <h1 class="font-bold text-lg" style="color:#f1f5f9">Profil</h1>
                <p class="text-sm" style="color:#64748b">Hesab ayarlarınız</p>
            </div>
            <!-- <a href="/chat" class="gradient-btn px-4 py-2 rounded-xl text-sm font-medium text-white flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Yeni Söhbət
            </a> -->

            <div class="flex items-center gap-3">
    <button onclick="toggleTheme()" id="themeBtn"
        class="w-9 h-9 rounded-full flex items-center justify-center transition-all"
        style="background:rgba(19,86,164,0.2); border:1px solid rgba(19,86,164,0.3)">
        <span id="themeIcon">🌙</span>
    </button>
    <a href="/chat" class="gradient-btn px-4 py-2 rounded-xl text-sm font-medium text-white flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        Yeni Söhbət
    </a>
</div>
        </div>

        <div class="max-w-4xl mx-auto px-8 py-8">

            {{-- Bildirişlər --}}
            @if(session('success'))
            <div class="mb-6 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2"
                 style="background:rgba(34,197,94,0.1); color:#4ade80; border:1px solid rgba(34,197,94,0.2)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 px-4 py-3 rounded-xl text-sm flex items-center gap-2"
                 style="background:rgba(239,68,68,0.1); color:#f87171; border:1px solid rgba(239,68,68,0.2)">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                {{ $errors->first() }}
            </div>
            @endif

            {{-- Avatar banner --}}
            <div class="rounded-2xl mb-6 overflow-hidden" style="background:linear-gradient(135deg,#1356A4 0%,#0A2240 100%)">
                <div class="px-8 py-8 flex items-center gap-6">
                    <div class="w-20 h-20 rounded-2xl flex items-center justify-center text-3xl font-bold flex-shrink-0"
                         style="background:rgba(255,255,255,0.15); color:#fff; backdrop-filter:blur(10px)">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-white mb-1">{{ Auth::user()->name }}</h2>
                        <p style="color:rgba(255,255,255,0.6)" class="text-sm mb-3">{{ Auth::user()->email }}</p>
                        <span class="px-3 py-1 rounded-full text-xs font-medium"
                              style="{{ Auth::user()->isAdmin() ? 'background:rgba(232,160,16,0.2);color:#F4B942' : 'background:rgba(255,255,255,0.1);color:rgba(255,255,255,0.8)' }}">
                            {{ Auth::user()->isAdmin() ? '⭐ Admin' : '👤 İstifadəçi' }}
                        </span>
                    </div>
                    {{-- Statistika --}}
                    <div class="flex gap-6">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ Auth::user()->conversations()->count() }}</div>
                            <div class="text-xs" style="color:rgba(255,255,255,0.5)">Söhbət</div>
                        </div>
                        <div class="w-px" style="background:rgba(255,255,255,0.1)"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-white">{{ Auth::user()->conversations()->withCount('messages')->get()->sum('messages_count') }}</div>
                            <div class="text-xs" style="color:rgba(255,255,255,0.5)">Mesaj</div>
                        </div>
                        <div class="w-px" style="background:rgba(255,255,255,0.1)"></div>
                        <div class="text-center">
                            <div class="text-2xl font-bold" style="color:#E8A010">{{ Auth::user()->created_at->format('d.m.Y') }}</div>
                            <div class="text-xs" style="color:rgba(255,255,255,0.5)">Üzvlük</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 2 sütun formlar --}}
            <div class="grid grid-cols-2 gap-5 mb-5">

                {{-- Profil məlumatları --}}
                <div class="rounded-2xl p-6 card-hover" style="background:#1e293b; border:1px solid #334155">
                    <h3 class="font-semibold mb-5 flex items-center gap-2" style="color:#f1f5f9">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(19,86,164,0.3)">
                            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        Profil Məlumatları
                    </h3>
                    <form method="POST" action="{{ route('profile.name') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Ad Soyad</label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" required class="input-field">
                        </div>
                        <div class="mb-5">
                            <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled class="input-field">
                            <p class="text-xs mt-1.5" style="color:#475569">Email dəyişdirilə bilməz</p>
                        </div>
                        <button type="submit" class="gradient-btn w-full py-3 rounded-xl text-sm font-semibold text-white flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Yadda Saxla
                        </button>
                    </form>
                </div>

                {{-- Şifrə dəyiş --}}
                <div class="rounded-2xl p-6 card-hover" style="background:#1e293b; border:1px solid #334155">
                    <h3 class="font-semibold mb-5 flex items-center gap-2" style="color:#f1f5f9">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background:rgba(19,86,164,0.3)">
                            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        Şifrə Dəyiş
                    </h3>
                    <form method="POST" action="{{ route('profile.password') }}">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Cari Şifrə</label>
                            <input type="password" name="current_password" required class="input-field" placeholder="••••••••">
                        </div>
                        <div class="mb-4">
                            <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Yeni Şifrə</label>
                            <input type="password" name="password" required class="input-field" placeholder="Min. 8 simvol">
                        </div>
                        <div class="mb-5">
                            <label class="block text-xs font-medium mb-2 uppercase tracking-wider" style="color:#94a3b8">Təsdiqlə</label>
                            <input type="password" name="password_confirmation" required class="input-field" placeholder="••••••••">
                        </div>
                        <button type="submit" class="gradient-btn w-full py-3 rounded-xl text-sm font-semibold text-white flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Şifrəni Dəyiş
                        </button>
                    </form>
                </div>
            </div>

            {{-- Hesabdan çıxış --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-3 rounded-2xl text-sm font-medium transition flex items-center justify-center gap-2"
                        style="color:#f87171; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2)"
                        onmouseover="this.style.background='rgba(239,68,68,0.15)'"
                        onmouseout="this.style.background='rgba(239,68,68,0.08)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Hesabdan Çıxış
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('themeIcon');
            if (btn) {
                btn.textContent = localStorage.getItem('theme') === 'light' ? '\u2600\uFE0F' : '\uD83C\uDF19';
            }
        });
    </script>
@endsection
