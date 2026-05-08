<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NPTM AI - @yield('title', 'Süni Zəka Platforması')</title>
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.setAttribute('data-theme', 'light');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: #1e293b; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 2px; }
        .chat-scroll::-webkit-scrollbar { width: 6px; }
        .chat-scroll::-webkit-scrollbar-track { background: #f1f5f9; }
        .chat-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50">

@yield('content')

@yield('scripts')

<script>
    function toggleTheme() {
        const root = document.documentElement;
        const btn = document.getElementById('themeIcon');
        const isLight = root.getAttribute('data-theme') === 'light';

        if (isLight) {
            root.removeAttribute('data-theme');
            if (btn) btn.textContent = '\uD83C\uDF19';
            localStorage.setItem('theme', 'dark');
        } else {
            root.setAttribute('data-theme', 'light');
            if (btn) btn.textContent = '\u2600\uFE0F';
            localStorage.setItem('theme', 'light');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('themeIcon');
        if (btn) {
            btn.textContent = localStorage.getItem('theme') === 'light' ? '\u2600\uFE0F' : '\uD83C\uDF19';
        }
    });
</script>

</body>
</html>
