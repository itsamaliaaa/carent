<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARENT - Rating & Ulasan Toyota Avanza 2023</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #0A194A; /* Dark blue from header/footer */
            --primary-accent: #1E3A8A; /* Slightly lighter accent blue */
            --bg-page: #F8F9FC; /* Light gray page background */
            --text-heading: #1F2937; /* Dark gray for main headers */
            --text-body: #6B7280; /* Lighter gray for body text */
            --star-gold: #FBBF24;
            --border-light: #E5E7EB;
        }

        body {
            font-family: 'Poppins', sans-serif; /* Recommended font, replace with Figma specified font */
            background-color: var(--bg-page);
            color: var(--text-heading);
        }

        /* --- Custom Helper Classes --- */
        .carent-btn-primary {
            @apply bg-[var(--primary)] text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-[var(--primary-accent)] transition-colors;
        }

        .carent-btn-secondary {
            @apply bg-white text-[var(--primary)] px-8 py-2.5 rounded-lg text-sm font-semibold border border-[var(--primary)] hover:bg-gray-100 transition-colors;
        }
    </style>
</head>
<body class="antialiased">

    <header class="bg-white sticky top-0 z-50 shadow-sm border-b border-[var(--border-light)]">
        <nav class="container mx-auto max-w-screen-2xl px-6 py-4 flex items-center justify-between">
            <a href="#" class="flex items-center gap-2">
                {{-- Replace with actual CARENT Logo asset --}}
                <div class="bg-[var(--primary)] text-white p-2.5 rounded-lg flex items-center justify-center font-bold text-lg">
                    C
                </div>
                <span class="text-[var(--primary)] font-bold text-xl uppercase tracking-wider">Carent</span>
            </a>
            <div class="flex items-center gap-10">
                <a href="#" class="text-sm font-medium hover:text-[var(--primary)]">Beranda</a>
                <a href="#" class="text-sm font-semibold text-[var(--primary)]">Katalog Mobil</a>
            </div>
            <div class="flex items-center gap-4">
                <button class="carent-btn-secondary">Daftar</button>
                <button class="carent-btn-primary">Masuk</button>
            </div>
        </nav>
    </header>

    {{-- --- Main Content --- --}}
    <main class="container mx-auto max-w-screen-2xl px-6 py-10">
        <div class="bg-white rounded-xl shadow-md border border-[var(--border-light)] p-8">

            {{-- --- Back Button --- --}}
            <a href="#" class="inline-flex items-center text-sm gap-2 text-[var(--primary)] font-semibold mb-8 hover:opacity-80">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-[var(--primary)]">
                    <path d="M15 19L8 12L15 5" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Kembali
            </a>

            {{-- --- Rating & Review Header --- --}}
            <div class="flex items-start gap-12 mb-12">
                <div class="w-[300px]">
                    <h1 class="text-3xl font-bold text-[var(--text-heading)]">Rating & Ulasan</h1>
                </div>

                <div class="flex-1 bg-gray-100 rounded-xl p-8 border border-[var(--border-light)]">
                    <div class="flex items-center gap-10 mb-8 pb-8 border-b border-[var(--border-light)]">
                        <div class="p-2 border border-dashed border-gray-300 rounded-lg">
                            {{-- Placeholder for Car Image, replace with actual asset --}}
                            <img src="https://via.placeholder.com/150x100?text=Mobil" alt="Toyota Avanza 2023" class="w-28 h-auto rounded-md object-cover">
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold">Toyota Avanza 2023</h2>
                            <p class="text-xl font-bold text-[var(--primary)] mt-1">Rp. 550.000<span class="text-gray-500 font-medium text-lg">/hari</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 items-center">
                        <div class="text-center">
                            <span class="text-[80px] font-bold leading-none">5.0</span>
                            <div class="flex items-center justify-center gap-1.5 my-3">
                                {{-- 5 Gold Stars --}}
                                @for($i = 0; $i < 5; $i++)
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="var(--star-gold)" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-[var(--text-body)] font-medium">(25 Rating & Ulasan)</span>
                        </div>
                        <div class="space-y-2.5">
                            {{-- Rating Breakdown (5 star) --}}
                            <div class="flex items-center gap-4 text-sm font-semibold">
                                <span class="w-6 text-right">5</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-[var(--primary)] h-3 rounded-full" style="width: 100%"></div>
                                </div>
                                <span class="w-6 text-left">24</span>
                            </div>
                            {{-- ... repeat for other stars, showing data in the design ... --}}
                            <div class="flex items-center gap-4 text-sm font-semibold">
                                <span class="w-6 text-right">4</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-[var(--primary)] h-3 rounded-full opacity-50" style="width: 4%"></div>
                                </div>
                                <span class="w-6 text-left">1</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm font-semibold text-gray-400">
                                <span class="w-6 text-right">3</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gray-200 h-3 rounded-full" style="width: 0%"></div>
                                </div>
                                <span class="w-6 text-left">0</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm font-semibold text-gray-400">
                                <span class="w-6 text-right">2</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gray-200 h-3 rounded-full" style="width: 0%"></div>
                                </div>
                                <span class="w-6 text-left">0</span>
                            </div>
                            <div class="flex items-center gap-4 text-sm font-semibold text-gray-400">
                                <span class="w-6 text-right">1</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-gray-200 h-3 rounded-full" style="width: 0%"></div>
                                </div>
                                <span class="w-6 text-left">0</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- --- Review List --- --}}
            <div class="space-y-12">
                {{-- Example Review 1 (Complex with images) --}}
                <div class="flex gap-10 border-b border-[var(--border-light)] pb-12 last:border-0 last:pb-0">
                    {{-- User Avatar --}}
                    <div class="relative w-16 h-16 rounded-full flex items-center justify-center font-bold text-white text-lg bg-gray-300">
                        {{-- Use first letters if no image, or a placeholder image --}}
                        A
                        <div class="absolute -bottom-1 -right-1 bg-green-500 w-5 h-5 rounded-full border-2 border-white"></div> {{-- Online status indicator --}}
                    </div>

                    <div class="flex-1 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-lg">arifnugroho57@gmail.com</h4>
                                <p class="text-sm text-[var(--text-body)] mt-0.5">14 Februari 2023</p>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--star-gold)" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="text-[var(--text-body)] leading-relaxed">
                            Secara keseluruhan oke banget. Mobil dalam kondisi bagus dan nyaman dipakai perjalanan jauh. Cuma waktu pengambilan sempat nunggu sedikit karena antrian tapi overall okay. Pelayanan staff juga ramah...
                        </p>

                        {{-- Images Section (Used in some reviews) --}}
                        <div class="flex gap-4">
                            {{-- Placeholder Review Images, replace with actual user assets --}}
                            <div class="p-1 border border-dashed border-gray-300 rounded-md">
                                <img src="https://via.placeholder.com/150x120?text=Bukti+1" alt="Review Image 1" class="w-36 h-auto rounded-sm object-cover">
                            </div>
                            <div class="p-1 border border-dashed border-gray-300 rounded-md">
                                <img src="https://via.placeholder.com/150x120?text=Bukti+2" alt="Review Image 2" class="w-36 h-auto rounded-sm object-cover">
                            </div>
                        </div>

                        {{-- Balasan Section (Present in example 1) --}}
                        <div class="bg-gray-100 rounded-lg p-6 border border-gray-200">
                            <h5 class="font-semibold text-[var(--primary)] mb-1">Balasan:</h5>
                            <p class="text-sm text-[var(--text-body)] leading-relaxed">
                                Terima kasih banyak atas ulasan positifnya, Kak arif! Kami senang mendengar bahwa pengalaman sewa Anda berjalan lancar... <a href="#" class="text-[var(--primary)] font-medium hover:underline">Lihat Selengkapnya</a>
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Example Review 2 (Simpler, text only) --}}
                <div class="flex gap-10 border-b border-[var(--border-light)] pb-12 last:border-0 last:pb-0">
                    <div class="relative w-16 h-16 rounded-full flex items-center justify-center font-bold text-white text-lg bg-[var(--primary)]">
                        H
                    </div>

                    <div class="flex-1 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-lg">hananfajry@gmail.com</h4>
                                <p class="text-sm text-[var(--text-body)] mt-0.5">14 Februari 2023</p>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 0; $i < 5; $i++)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="var(--star-gold)" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="text-[var(--text-body)] leading-relaxed">
                            Proses booking sangat cepat dan tidak berbelit-belit. Saat pengambilan mobil juga tidak memakan waktu lama. Mobilnya bersih, wangi...
                        </p>
                    </div>
                </div>

                {{-- Add more static reviews from the image as needed, or loop through dynamic data in Laravel --}}
            </div>

            {{-- --- Show More Button --- --}}
            <div class="mt-16 text-right">
                <button class="carent-btn-secondary !text-white bg-[var(--primary)] border-[var(--primary)]">
                    Tampilkan Lebih Banyak
                </button>
            </div>
        </div>
    </main>

    {{-- --- Footer --- --}}
    <footer class="bg-[var(--primary)] text-gray-200 mt-20">
        <div class="container mx-auto max-w-screen-2xl px-6 py-16 grid grid-cols-1 md:grid-cols-[1.5fr_1fr_1fr_1.2fr] gap-12">
            <div>
                <a href="#" class="flex items-center gap-2 mb-6">
                    <div class="bg-white text-[var(--primary)] p-2 rounded-lg flex items-center justify-center font-bold text-base">
                        C
                    </div>
                    <span class="text-white font-bold text-xl uppercase tracking-wider">Carent</span>
                </a>
                <p class="text-sm text-gray-300 leading-relaxed mb-8">
                    Platform sewa mobil dan berbagai paket wisata terlengkap dan terpercaya...
                </p>
                <div class="flex items-center gap-4">
                    {{-- Replace with actual Social Media SVG Icons --}}
                    @foreach(['facebook', 'instagram', 'twitter'] as $social)
                        <a href="#" class="w-10 h-10 border border-gray-600 rounded-full flex items-center justify-center text-gray-400 hover:text-white hover:border-gray-500 transition">
                            {{-- Placeholder SVG --}}
                            <svg width="20" height="20" fill="currentColor" class="bi bi-{{$social}}" viewBox="0 0 16 16">
                                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0z"/>
                            </svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="space-y-4">
                <h6 class="font-bold text-white mb-6">Menu</h6>
                <a href="#" class="block text-sm hover:text-white">Alur Jasa Temu</a>
                <a href="#" class="block text-sm hover:text-white">Katalog Mobil</a>
                <a href="#" class="block text-sm hover:text-white">Daftar Paket</a>
                <a href="#" class="block text-sm hover:text-white">Paket Liburan</a>
            </div>

            <div class="space-y-4">
                <h6 class="font-bold text-white mb-6">Layanan</h6>
                <a href="#" class="block text-sm hover:text-white">Sewa Mobil</a>
                <a href="#" class="block text-sm hover:text-white">Booking Online</a>
                <a href="#" class="block text-sm hover:text-white">Sewa Driver Efektif</a>
            </div>

            <div class="space-y-4">
                <h6 class="font-bold text-white mb-6">Contact</h6>
                <a href="tel:+6201912227" class="block text-sm hover:text-white">+62 019 1222 7</a>
                <a href="mailto:info@carentmail.com" class="block text-sm hover:text-white">info@carentmail.com</a>
                <p class="text-sm text-gray-300 mt-2">Indonesia</p>
            </div>
        </div>

        <div class="container mx-auto max-w-screen-2xl px-6 py-6 border-t border-gray-800 text-center text-sm text-gray-400">
            © 2023 CARENT - Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>
