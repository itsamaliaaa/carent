<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CARENT - Rating & Ulasan {{ $mobil->nama_mobil }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #0A194A;
            --primary-accent: #1E3A8A;
            --bg-page: #F8F9FC;
            --text-heading: #1F2937;
            --text-body: #6B7280;
            --star-gold: #FBBF24;
            --border-light: #E5E7EB;
        }
        body { font-family: 'Poppins', sans-serif; background-color: var(--bg-page); color: var(--text-heading); }
        .carent-btn-primary { @apply bg-[var(--primary)] text-white px-8 py-2.5 rounded-lg text-sm font-semibold hover:bg-[var(--primary-accent)] transition-colors; }
        .carent-btn-secondary { @apply bg-white text-[var(--primary)] px-8 py-2.5 rounded-lg text-sm font-semibold border border-[var(--primary)] hover:bg-gray-100 transition-colors; }
    </style>
</head>
<body class="antialiased">

    {{-- Header (Keep your existing header here) --}}

    <main class="container mx-auto max-w-screen-2xl px-6 py-10">
        <div class="bg-white rounded-xl shadow-md border border-[var(--border-light)] p-8">

            <a href="javascript:history.back()" class="inline-flex items-center text-sm gap-2 text-[var(--primary)] font-semibold mb-8 hover:opacity-80">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 19L8 12L15 5"/></svg>
                Kembali
            </a>

            <div class="flex items-start gap-12 mb-12">
                <div class="w-[300px]">
                    <h1 class="text-3xl font-bold text-[var(--text-heading)]">Rating & Ulasan</h1>
                </div>

                <div class="flex-1 bg-gray-100 rounded-xl p-8 border border-[var(--border-light)]">
                    <div class="flex items-center gap-10 mb-8 pb-8 border-b border-[var(--border-light)]">
                        <div class="p-2 border border-dashed border-gray-300 rounded-lg bg-white">
                            {{-- Check if car has a primary image, otherwise show placeholder --}}
                            @php
                                $primaryImg = $mobil->fotoMobil->first();
                            @endphp
                            @if($primaryImg)
                                <img src="{{ asset('storage/' . $primaryImg->url_foto) }}" alt="{{ $mobil->nama_mobil }}" class="w-28 h-auto rounded-md object-cover">
                            @else
                                <img src="https://via.placeholder.com/150x100?text=No+Image" alt="{{ $mobil->nama_mobil }}" class="w-28 h-auto rounded-md object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h2 class="text-2xl font-bold">{{ $mobil->nama_mobil }} {{ $mobil->tahun }}</h2>
                            <p class="text-xl font-bold text-[var(--primary)] mt-1">Rp. {{ number_format($mobil->harga_per_hari, 0, ',', '.') }}<span class="text-gray-500 font-medium text-lg">/hari</span></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6 items-center">
                        <div class="text-center">
                            <span class="text-[80px] font-bold leading-none">{{ $averageRating }}</span>
                            <div class="flex items-center justify-center gap-1.5 my-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="{{ $i <= round($averageRating) ? 'var(--star-gold)' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-sm text-[var(--text-body)] font-medium">({{ $totalReviews }} Rating & Ulasan)</span>
                        </div>
                        <div class="space-y-2.5">
                            @for($star = 5; $star >= 1; $star--)
                            <div class="flex items-center gap-4 text-sm font-semibold {{ $ratingCounts[$star] == 0 ? 'text-gray-400' : '' }}">
                                <span class="w-6 text-right">{{ $star }}</span>
                                <div class="w-full bg-gray-200 rounded-full h-3">
                                    <div class="bg-[var(--primary)] h-3 rounded-full {{ $ratingPercentages[$star] < 100 && $ratingPercentages[$star] > 0 ? 'opacity-70' : '' }}" style="width: {{ $ratingPercentages[$star] }}%"></div>
                                </div>
                                <span class="w-6 text-left">{{ $ratingCounts[$star] }}</span>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-12">
                @forelse($reviews as $review)
                <div class="flex gap-10 border-b border-[var(--border-light)] pb-12 last:border-0 last:pb-0">

                    <div class="relative w-16 h-16 rounded-full flex items-center justify-center font-bold text-white text-lg bg-gray-300 overflow-hidden">
                        @if($review->user->foto_profile)
                            <img src="{{ asset('storage/' . $review->user->foto_profile) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            {{ strtoupper(substr($review->user->nama_lengkap, 0, 1)) }}
                        @endif
                    </div>

                    <div class="flex-1 space-y-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="font-semibold text-lg">{{ $review->user->nama_lengkap }}</h4>
                                <p class="text-sm text-[var(--text-body)] mt-0.5">{{ $review->tanggal_posting->translatedFormat('d F Y') }}</p>
                            </div>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="{{ $i <= $review->rating ? 'var(--star-gold)' : '#E5E7EB' }}" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z" fill="currentColor"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>

                        <p class="text-[var(--text-body)] leading-relaxed">
                            {{ $review->komentar }}
                        </p>

                        {{-- Balasan Section (From reply_review table) --}}
                        @if($review->replyReview)
                        <div class="bg-gray-100 rounded-lg p-6 border border-gray-200">
                            <h5 class="font-semibold text-[var(--primary)] mb-1">Balasan Admin:</h5>
                            <p class="text-sm text-[var(--text-body)] leading-relaxed">
                                {{ $review->replyReview->komentar }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                    <div class="text-center py-12">
                        <p class="text-gray-500 font-medium">Belum ada ulasan untuk mobil ini.</p>
                    </div>
                @endforelse
            </div>

            @if($totalReviews > 0)
            <div class="mt-16 text-right">
                <button class="carent-btn-secondary !text-white bg-[var(--primary)] border-[var(--primary)]">
                    Tampilkan Lebih Banyak
                </button>
            </div>
            @endif
        </div>
    </main>

    {{-- Footer (Keep your existing footer here) --}}
</body>
</html>
