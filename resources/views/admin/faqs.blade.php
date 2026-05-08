@extends('layout')

@section('title', 'FAQ İdarəsi')

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

        <!-- Naviqasiya -->
        <div class="flex gap-3 mb-8">
            <a href="/admin" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">Dashboard</a>
            <a href="/admin/users" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">İstifadəçilər</a>
            <a href="/admin/faqs" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium">FAQ İdarəsi</a>
            <a href="/admin/conversations" class="bg-white text-gray-600 hover:bg-gray-50 px-5 py-2 rounded-lg text-sm font-medium border">Söhbətlər</a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
        @endif

        <!-- Yeni FAQ əlavə et -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-800">Yeni FAQ Əlavə Et</h2>
            </div>
            <form method="POST" action="{{ route('admin.faqs.store') }}" class="p-6">
                @csrf
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Sual</label>
                        <input type="text" name="question" required
                            class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Sualı yazın...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kateqoriya</label>
                        <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="poct">Poçt</option>
                            <option value="telekom">Telekommunikasiya</option>
                            <option value="general">Ümumi</option>
                        </select>
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cavab</label>
                    <textarea name="answer" required rows="3"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Cavabı yazın..."></textarea>
                </div>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition">
                    Əlavə Et
                </button>
            </form>
        </div>

        <!-- FAQ siyahısı -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="px-6 py-4 border-b">
                <h2 class="font-semibold text-gray-800">FAQ Siyahısı ({{ $faqs->total() }})</h2>
            </div>
            <div class="divide-y">
                @forelse($faqs as $faq)
                <div class="px-6 py-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full">{{ $faq->category }}</span>
                                <span class="text-xs {{ $faq->is_active ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} px-2 py-0.5 rounded-full">
                                    {{ $faq->is_active ? 'Aktiv' : 'Deaktiv' }}
                                </span>
                            </div>
                            <div class="font-medium text-gray-800 text-sm mb-1">{{ $faq->question }}</div>
                            <div class="text-gray-500 text-sm">{{ $faq->answer }}</div>
                        </div>
                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Silmək istədiyinizə əminsiniz?')"
                                class="text-red-400 hover:text-red-600 text-xs transition">
                                Sil
                            </button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-400 text-sm">Hələ FAQ yoxdur</div>
                @endforelse
            </div>
            <div class="px-6 py-4 border-t">
                {{ $faqs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection