@extends('layout')

@section('title', 'AI Söhbət')

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
</style>
@endsection

@section('content')
<div class="flex h-screen overflow-hidden" style="background:#0f172a">

    {{-- ═══ SOL PANEL ═══ --}}
    <div class="w-64 flex flex-col flex-shrink-0" style="background:#0A2240; border-right:1px solid rgba(255,255,255,0.06)">

        {{-- Logo --}}
        <div class="px-4 py-4 border-b" style="border-color:rgba(255,255,255,0.08)">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background:#E8A010">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <div>
                    <div class="font-bold text-sm text-white">NPTM AI</div>
                    <div class="text-xs" style="color:#60a5fa">ai.nptm.gov.az</div>
                </div>
            </div>
        </div>

        {{-- Yeni söhbət --}}
        <div class="px-3 pt-3 pb-2">
            <a href="/chat" class="gradient-btn flex items-center gap-2 w-full px-3 py-2.5 rounded-xl text-sm font-medium text-white">
                <svg class="w-4 h-4" style="color:#E8A010" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Yeni Söhbət
            </a>
        </div>

        {{-- Menyu --}}
        <div class="px-3 py-2">
            <div class="text-xs px-2 py-1 font-medium uppercase tracking-wider mb-1" style="color:#475569">Menyu</div>
            <a href="/chat" class="conv-item flex items-center gap-2.5 px-3 py-2.5 mb-0.5 text-sm"
               style="background:rgba(232,160,16,0.15); color:#F4B942; border-left:2px solid #E8A010; border-radius:10px">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
                Söhbət
            </a>
            <a href="/profile" class="conv-item flex items-center gap-2.5 px-3 py-2.5 mb-0.5 text-sm" style="color:#94a3b8">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                Profil
            </a>
        </div>

        {{-- Söhbət siyahısı --}}
        <div class="text-xs px-5 py-2 font-medium uppercase tracking-wider" style="color:#475569">
            Son Söhbətlər
        </div>
        <div class="flex-1 overflow-y-auto sidebar-scroll px-2 pb-2">
            @forelse($conversations as $conv)
            <div class="conv-item flex items-center gap-2 px-3 py-2.5 mb-0.5 group">
                <a href="/chat/{{ $conv->id }}" class="flex items-center gap-2 flex-1 min-w-0"
                   style="{{ isset($conversation) && $conversation->id === $conv->id ? 'color:#F4B942' : 'color:#94a3b8' }}">
                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span class="text-sm truncate">{{ $conv->title }}</span>
                </a>
                <form method="POST" action="/chat/{{ $conv->id }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" onclick="return confirm('Silinsin?')"
                        class="del-btn p-1 rounded-lg transition"
                        style="color:#ef4444"
                        onmouseover="this.style.background='rgba(239,68,68,0.15)'"
                        onmouseout="this.style.background='transparent'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
            @empty
            <div class="text-center py-6 text-xs" style="color:#475569">Hələ söhbət yoxdur</div>
            @endforelse
        </div>

        {{-- İstifadəçi --}}
        <div class="px-3 py-3 border-t" style="border-color:rgba(255,255,255,0.08)">
            <div class="flex items-center gap-2.5 px-2 py-2 rounded-xl" style="background:rgba(255,255,255,0.05)">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold flex-shrink-0"
                     style="background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-medium truncate text-white">{{ Auth::user()->name }}</div>
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
                    <button class="w-full text-xs py-1.5 rounded-lg transition"
                            style="color:#64748b; background:rgba(255,255,255,0.05)"
                            onmouseover="this.style.color='#ef4444'"
                            onmouseout="this.style.color='#64748b'">
                        Çıxış
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- ═══ ƏSAS CHAT SAHƏSİ ═══ --}}
    <div class="flex-1 flex flex-col min-w-0" style="background:#0f172a">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-3.5 border-b" style="border-color:rgba(255,255,255,0.06)">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center" style="background:rgba(19,86,164,0.3)">
                        <svg class="w-5 h-5" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                        </svg>
                    </div>
                    <div class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2" style="background:#22c55e; border-color:#0f172a"></div>
                </div>
                <div>
                    <div class="font-semibold text-sm text-white">NPTM AI Köməkçisi</div>
                    <div class="text-xs" style="color:#22c55e">● Online · Hazırdır</div>
                </div>
            </div>

        {{-- Model Dropdown --}}
<div class="relative">
    <button onclick="toggleModelDropdown()" id="modelDropdownBtn"
        class="flex items-center gap-2 text-xs px-3 py-1.5 rounded-full transition-all"
        style="background:rgba(19,86,164,0.2); color:#60a5fa; border:1px solid rgba(19,86,164,0.3)">
       <span id="modelDot">⚡</span>
        <span id="modelLabel">Groq — Llama 3.3</span>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>

    <div id="modelDropdown" class="absolute right-0 mt-2 rounded-2xl shadow-xl z-50 hidden"
        style="background:#1e293b; border:1px solid #334155; min-width:240px; top:100%">
        <div class="p-2">
            <div class="text-xs px-3 py-1.5 font-medium uppercase tracking-wider mb-1" style="color:#475569">Model seç</div>

            {{-- Groq --}}
            <button onclick="selectModel('groq', 'Groq — Llama 3.3', '#22c55e')"
                class="model-option w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-all"
                style="background:rgba(19,86,164,0.2)">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#f97316">
                    <span class="text-white font-bold text-xs">G</span>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-white">Groq</div>
                    <div class="text-xs" style="color:#64748b">Llama 3.3 · 70B</div>
                </div>
                <svg class="w-4 h-4" id="check-groq" style="color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>

            {{-- OpenAI --}}
            <button onclick="selectModel('openai', 'OpenAI — GPT-4o mini', '#f59e0b')"
                class="model-option w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-all">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#10a37f">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M22.282 9.821a5.985 5.985 0 0 0-.516-4.91 6.046 6.046 0 0 0-6.51-2.9A6.065 6.065 0 0 0 4.981 4.18a5.985 5.985 0 0 0-3.998 2.9 6.046 6.046 0 0 0 .743 7.097 5.98 5.98 0 0 0 .51 4.911 6.051 6.051 0 0 0 6.515 2.9A5.985 5.985 0 0 0 13.26 24a6.056 6.056 0 0 0 5.772-4.206 5.99 5.99 0 0 0 3.997-2.9 6.056 6.056 0 0 0-.747-7.073zM13.26 22.43a4.476 4.476 0 0 1-2.876-1.04l.141-.081 4.779-2.758a.795.795 0 0 0 .392-.681v-6.737l2.02 1.168a.071.071 0 0 1 .038.052v5.583a4.504 4.504 0 0 1-4.494 4.494zM3.6 18.304a4.47 4.47 0 0 1-.535-3.014l.142.085 4.783 2.759a.771.771 0 0 0 .78 0l5.843-3.369v2.332a.08.08 0 0 1-.033.062L9.74 19.95a4.5 4.5 0 0 1-6.14-1.646zM2.34 7.896a4.485 4.485 0 0 1 2.366-1.973V11.6a.766.766 0 0 0 .388.676l5.815 3.355-2.02 1.168a.076.076 0 0 1-.071 0l-4.83-2.786A4.504 4.504 0 0 1 2.34 7.872zm16.597 3.855l-5.833-3.387L15.119 7.2a.076.076 0 0 1 .071 0l4.83 2.791a4.494 4.494 0 0 1-.676 8.105v-5.678a.79.79 0 0 0-.407-.667zm2.01-3.023l-.141-.085-4.774-2.782a.776.776 0 0 0-.785 0L9.409 9.23V6.897a.066.066 0 0 1 .028-.061l4.83-2.787a4.5 4.5 0 0 1 6.68 4.66zm-12.64 4.135l-2.02-1.164a.08.08 0 0 1-.038-.057V6.075a4.5 4.5 0 0 1 7.375-3.453l-.142.08L8.704 5.46a.795.795 0 0 0-.393.681zm1.097-2.365l2.602-1.5 2.607 1.5v2.999l-2.597 1.5-2.607-1.5z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-white">OpenAI</div>
                    <div class="text-xs" style="color:#64748b">GPT-4o mini</div>
                </div>
                <svg class="w-4 h-4 hidden" id="check-openai" style="color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>

            {{-- Gemini --}}
            <button onclick="selectModel('gemini', 'Gemini — Flash 2.0', '#f59e0b')"
                class="model-option w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-all">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:linear-gradient(135deg,#4285f4,#ea4335,#fbbc05,#34a853)">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 24A14.304 14.304 0 000 12 14.304 14.304 0 0012 0a14.304 14.304 0 0012 12 14.304 14.304 0 00-12 12"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-white">Gemini</div>
                    <div class="text-xs" style="color:#64748b">Flash 2.0</div>
                </div>
                <svg class="w-4 h-4 hidden" id="check-gemini" style="color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>

            {{-- DeepSeek --}}
            <button onclick="selectModel('deepseek', 'DeepSeek — Chat', '#f59e0b')"
                class="model-option w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-left transition-all">
                <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0" style="background:#1a6fff">
                    <svg class="w-4 h-4 text-white" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14H9V8h2v8zm4 0h-2V8h2v8z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="text-sm font-medium text-white">DeepSeek</div>
                    <div class="text-xs" style="color:#64748b">DeepSeek Chat</div>
                </div>
                <svg class="w-4 h-4 hidden" id="check-deepseek" style="color:#22c55e" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>

{{-- Dark/Light Mode --}}
<button onclick="toggleTheme()" id="themeBtn"
    class="w-9 h-9 rounded-full flex items-center justify-center transition-all ml-2"
    style="background:rgba(19,86,164,0.2); border:1px solid rgba(19,86,164,0.3)">
    <span id="themeIcon">🌙</span>
</button>
        </div>

        {{-- Mesajlar --}}
        <div class="flex-1 overflow-y-auto chat-scroll" id="messages" style="padding:24px">

            @if(empty($messages) || count($messages) === 0)
            <div class="flex flex-col items-center justify-center h-full" id="welcome-screen">
                <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-5 shadow-lg"
                     style="background:linear-gradient(135deg,#1356A4,#0A2240)">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold mb-1 text-white">Salam, {{ Auth::user()->name }}!</h2>
                <p class="text-sm mb-8 text-center max-w-sm" style="color:#64748b">
                    NPTM xidmətləri haqqında istənilən sualınızı soruşun
                </p>
                <div class="grid grid-cols-2 gap-3 w-full max-w-lg">
                    @foreach([
                        ['icon'=>'📮','label'=>'Poçt','q'=>'Bağlama necə göndərilir?'],
                        ['icon'=>'📡','label'=>'Telekom','q'=>'İnternet tariflər nə qədərdir?'],
                        ['icon'=>'📍','label'=>'Filiallar','q'=>'Ən yaxın filial harada?'],
                        ['icon'=>'📦','label'=>'İzləmə','q'=>'Göndərişimi necə izləyim?'],
                    ] as $item)
                    <button onclick="sendQuickMessage('{{ $item['q'] }}')" class="quick-card flex items-center gap-3 p-4 rounded-2xl text-left">
                        <span class="text-2xl">{{ $item['icon'] }}</span>
                        <div>
                            <div class="text-sm font-semibold text-white">{{ $item['label'] }}</div>
                            <div class="text-xs" style="color:#64748b">{{ $item['q'] }}</div>
                        </div>
                    </button>
                    @endforeach
                </div>
            </div>

            @else
            @foreach($messages as $message)
            <div class="flex mb-5 message-enter {{ $message->role === 'user' ? 'justify-end' : 'justify-start' }}">
                @if($message->role === 'assistant')
                <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0 mt-0.5"
                     style="background:rgba(19,86,164,0.3)">
                    <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                @endif

                <div class="max-w-xl rounded-2xl px-4 py-3 shadow-sm
                    {{ $message->role === 'user' ? 'rounded-br-sm' : 'rounded-bl-sm' }}"
                    style="{{ $message->role === 'user'
                        ? 'background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff'
                        : 'background:#1e293b; color:#e2e8f0; border:1px solid #334155' }}">
                    <p class="text-sm leading-relaxed">{{ $message->content }}</p>
                    <p class="text-xs mt-1.5" style="{{ $message->role === 'user' ? 'color:rgba(255,255,255,0.5)' : 'color:#475569' }}">
                        {{ $message->created_at->format('H:i') }}
                    </p>
                </div>

                @if($message->role === 'user')
                <div class="w-8 h-8 rounded-full flex items-center justify-center ml-3 flex-shrink-0 mt-0.5 text-sm font-bold"
                     style="background:linear-gradient(135deg,#1356A4,#0A2240); color:#fff">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                @endif
            </div>
            @endforeach
            @endif
        </div>

        {{-- Input --}}
        <div class="px-6 py-4 border-t" style="border-color:rgba(255,255,255,0.06)">
            <div class="max-w-3xl mx-auto">
                <div class="input-area flex items-center gap-3 rounded-2xl px-4 py-3" id="input-container">
                    <textarea id="messageInput"
                        placeholder="Sualınızı yazın... (Enter göndər)"
                        rows="1"
                        class="flex-1 bg-transparent resize-none outline-none text-sm"
                        style="color:#e2e8f0; max-height:120px"
                        onkeydown="handleKeyDown(event)"
                        oninput="autoResize(this)"></textarea>
                    <button onclick="sendMessage()" id="sendBtn"
                        class="gradient-btn w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                    </button>
                </div>
                <p class="text-center text-xs mt-2" style="color:#475569">
                    NPTM AI səhv cavablar verə bilər. Mühüm məsələlər üçün
                    <span style="color:#60a5fa; font-weight:500">106</span> nömrəli çağrı mərkəzi ilə əlaqə saxlayın.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
let currentConversationId = {{ isset($conversation) ? $conversation->id : 'null' }};
let currentModel = 'groq';
let isLoading = false;

function toggleModelDropdown() {
    const dropdown = document.getElementById('modelDropdown');
    dropdown.classList.toggle('hidden');
}

function selectModel(model, label, color) {
    currentModel = model;
    document.getElementById('modelLabel').textContent = label;

    ['groq', 'openai', 'gemini', 'deepseek'].forEach(m => {
        const check = document.getElementById('check-' + m);
        const btn = check.closest('button');
        if (m === model) {
            check.classList.remove('hidden');
            btn.style.background = 'rgba(19,86,164,0.2)';
        } else {
            check.classList.add('hidden');
            btn.style.background = 'transparent';
        }
    });

    document.getElementById('modelDropdown').classList.add('hidden');
}

document.addEventListener('click', function(e) {
    const dropdown = document.getElementById('modelDropdown');
    const btn = document.getElementById('modelDropdownBtn');
    if (!dropdown.contains(e.target) && !btn.contains(e.target)) {
        dropdown.classList.add('hidden');
    }
});

function handleKeyDown(e) {
    if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
    }
}

function autoResize(el) {
    el.style.height = 'auto';
    el.style.height = Math.min(el.scrollHeight, 120) + 'px';
}

function sendQuickMessage(text) {
    document.getElementById('messageInput').value = text;
    sendMessage();
}

function sendMessage() {
    const input = document.getElementById('messageInput');
    const message = input.value.trim();
    if (!message || isLoading) return;

    isLoading = true;
    input.value = '';
    input.style.height = 'auto';

    const welcome = document.getElementById('welcome-screen');
    if (welcome) welcome.remove();

    appendMessage('user', message);
    const loadingId = appendLoading();

    fetch('/chat/send', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ message, conversation_id: currentConversationId, model: currentModel }),
    })
    .then(r => r.json())
    .then(data => {
        removeLoading(loadingId);
        if (data.success) {
            currentConversationId = data.conversation_id;
            appendMessage('assistant', data.response);
            window.history.replaceState({}, '', '/chat/' + data.conversation_id);
        }
    })
    .catch(() => {
        removeLoading(loadingId);
        appendMessage('assistant', 'Xəta baş verdi. Zəhmət olmasa yenidən cəhd edin.');
    })
    .finally(() => { isLoading = false; });
}

function appendMessage(role, content) {
    const messages = document.getElementById('messages');
    const isUser = role === 'user';
    const initial = '{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}';
    const now = new Date().toLocaleTimeString('az', {hour:'2-digit', minute:'2-digit'});

    const div = document.createElement('div');
    div.className = `flex mb-5 message-enter ${isUser ? 'justify-end' : 'justify-start'}`;
    div.innerHTML = `
        ${!isUser ? `<div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0 mt-0.5" style="background:rgba(19,86,164,0.3)">
            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
        </div>` : ''}
        <div class="max-w-xl rounded-2xl px-4 py-3 shadow-sm ${isUser ? 'rounded-br-sm' : 'rounded-bl-sm'}"
             style="${isUser
                ? 'background:linear-gradient(135deg,#1356A4,#0A2240);color:#fff'
                : 'background:#1e293b;color:#e2e8f0;border:1px solid #334155'}">
            <p class="text-sm leading-relaxed">${escapeHtml(content)}</p>
            <p class="text-xs mt-1.5" style="${isUser ? 'color:rgba(255,255,255,0.5)' : 'color:#475569'}">${now}</p>
        </div>
        ${isUser ? `<div class="w-8 h-8 rounded-full flex items-center justify-center ml-3 flex-shrink-0 mt-0.5 text-sm font-bold"
             style="background:linear-gradient(135deg,#1356A4,#0A2240);color:#fff">${initial}</div>` : ''}
    `;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
}

function appendLoading() {
    const messages = document.getElementById('messages');
    const id = 'loading-' + Date.now();
    const div = document.createElement('div');
    div.id = id;
    div.className = 'flex mb-5 justify-start';
    div.innerHTML = `
        <div class="w-8 h-8 rounded-full flex items-center justify-center mr-3 flex-shrink-0" style="background:rgba(19,86,164,0.3)">
            <svg class="w-4 h-4" style="color:#60a5fa" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
        </div>
        <div class="rounded-2xl rounded-bl-sm px-4 py-3" style="background:#1e293b;border:1px solid #334155">
            <div class="flex gap-1 items-center h-5">
                <div class="w-2 h-2 rounded-full typing-dot" style="background:#60a5fa"></div>
                <div class="w-2 h-2 rounded-full typing-dot" style="background:#60a5fa"></div>
                <div class="w-2 h-2 rounded-full typing-dot" style="background:#60a5fa"></div>
            </div>
        </div>
    `;
    messages.appendChild(div);
    messages.scrollTop = messages.scrollHeight;
    return id;
}

function removeLoading(id) {
    const el = document.getElementById(id);
    if (el) el.remove();
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.appendChild(document.createTextNode(text));
    return div.innerHTML;
}

// function toggleTheme() {
//     const root = document.documentElement;
//     const btn = document.getElementById('themeIcon');
//     const isLight = root.getAttribute('data-theme') === 'light';

//     if (isLight) {
//         root.removeAttribute('data-theme');
//         btn.textContent = '🌙';
//         localStorage.setItem('theme', 'dark');
//     } else {
//         root.setAttribute('data-theme', 'light');
//         btn.textContent = '☀️';
//         localStorage.setItem('theme', 'light');
//     }
// }

// Səhifə açılanda saxlanmış temaya bax
if (localStorage.getItem('theme') === 'light') {
    document.documentElement.setAttribute('data-theme', 'light');
    document.getElementById('themeIcon').textContent = '☀️';
}

document.getElementById('messages').scrollTop = document.getElementById('messages').scrollHeight;
</script>
@endsection
