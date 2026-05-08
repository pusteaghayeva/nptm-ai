@extends('layout')

@section('title', 'Admin Panel')

@section('content')
<div class="min-h-screen bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-slate-900 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <span class="text-white font-bold">NPTM AI — Admin Panel</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="/chat" class="text-gray-300 hover:text-white text-sm transition">Chat</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-gray-300 hover:text-red-400 text-sm transition">Çıxış</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">

        <!-- Statistika -->
        <div class="grid grid-cols-4 gap-6 mb-8">
            @foreach([
                ['label' => 'İstifadəçilər', 'value' => $stats['total_users'], 'color' => 'blue'],
                ['label' => 'Söhbətlər', 'value' => $stats['total_conversations'], 'color' => 'green'],
                ['label' => 'Mesajlar', 'value' => $stats['total_messages'], 'color' => 'purple'],
                ['label' => 'FAQ', 'value' => $stats['total_faqs'], 'color' => 'amber'],
            ] as $stat)
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-{{ $stat['color'] }}-600 mb-1">{{ $stat['value'] }}</div>
                <div class="text-gray-500 text-sm">{{ $stat['label'] }}</div>
            </div>
            @endforeach
        </div>

        <!-- Naviqasiya -->
        <div class="flex gap-3 mb-8">
            <a href="/admin" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium">Dashboard</a>
            <a href="/admin/users" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">İstifadəçilər</a>
            <a href="/admin/faqs" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">FAQ İdarəsi</a>
            <a href="/admin/conversations" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">Söhbətlər</a>
        </div>

        <!-- Son söhbətlər -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-800">Son Söhbətlər</h2>
            </div>
            <div class="divide-y">
                @forelse($recentConversations as $conv)
                <div class="px-6 py-4 flex items-center justify-between">
                    <div>
                        <div class="font-medium text-gray-800 text-sm">{{ $conv->title }}</div>
                        <div class="text-gray-400 text-xs mt-1">{{ $conv->user->name }} — {{ $conv->created_at->diffForHumans() }}</div>
                    </div>
                    <span class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-full">
                        {{ $conv->messages->count() }} mesaj
                    </span>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Hələ söhbət yoxdur</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection