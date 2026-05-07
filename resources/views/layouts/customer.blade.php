<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <title>Carent</title>
    
    @vite('resources/css/app.css')
</head>
<body class="font-inter">

    {{-- Navbar --}}
    @include('components.header.customer')

    {{-- Konten halaman --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.footer')

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('menuBtn');
        const menu = document.getElementById('mobileMenu');

        if (btn && menu) {
            btn.addEventListener('click', () => {
                menu.classList.toggle('hidden');
            });
        }
    });
    </script>

</body>
</html>