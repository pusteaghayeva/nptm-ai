@extends('layout')

@section('title', 'Qeydiyyat')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-amber-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">NPTM AI</h1>
            <p class="text-blue-300 text-sm mt-1">Yeni hesab yaradın</p>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl p-8 shadow-2xl">
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 text-sm">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}">
                @csrf
                
                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Ad Soyad</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Adınız Soyadınız">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="email@example.com">
                </div>

                <div class="mb-5">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Şifrə</label>
                    <input type="password" name="password" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Minimum 8 simvol">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 text-sm font-medium mb-2">Şifrəni təsdiq et</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                        placeholder="Şifrəni təkrar yazın">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    Qeydiyyatdan keç
                </button>
            </form>

            <p class="text-center text-gray-500 text-sm mt-6">
                Hesabınız var?
                <a href="/login" class="text-blue-600 hover:underline font-medium">Daxil olun</a>
            </p>
        </div>

        <p class="text-center text-blue-300 text-xs mt-6">
            © {{ date('Y') }} NPTM AI — Naxçıvan Poçt və Telekommunikasiya Mərkəzi
        </p>
    </div>
</div>
@endsection