<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin - Carent</title>

    {{-- FONT --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- CSS --}}
    @vite('resources/css/app.css')
</head>
<body class="font-inter bg-gray-100">

    {{-- NAVBAR --}}
    @include('components.header.dashboard')

    <div class="flex">

        {{-- SIDEBAR --}}
        @include('components.sidebar.dashboard')
        
        {{-- MAIN CONTENT --}}
        <main class="flex-1 p-6">
            @yield('content')
        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.getElementById('openSidebar');
            const sidebar = document.getElementById('sidebar');

            if (btn && sidebar) {
                btn.addEventListener('click', () => {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }
        });
    </script>

</body>
</html>