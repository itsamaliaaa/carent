<!-- Kalau cuman 1 halaman gak akan ada pagination -->
@if ($paginator->hasPages())
<nav>
    @php
    // Halaman yang dibuka
    $current = $paginator->currentPage();
    // Total halaman
    $last = $paginator->lastPage();
    @endphp

    <!-- untuk hover -->
    <style>
        .pagination-btn:hover {
            background: #0e2781 !important;
            color: white !important;
        }
    </style>

    <div style="display:inline-flex; border:1px solid #1D2B6B; overflow:hidden;">

        {{-- Tombol < --}}
        @if ($paginator->onFirstPage())
        {{-- Kalau di halaman pertama tombol < tidak bisa diklik --}}
        <span style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-right:1px solid #1D2B6B;color:#1D2B6B;font-weight:600;background:white; cursor:default;">
            &lt;
        </span>
        @else
        {{-- Kalau bukan halaman pertama tombol < bisa diklik --}}
        <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-right:1px solid #1D2B6B;color:#1D2B6B;font-weight:600;background:white;text-decoration:none;">
            &lt;
        </a>
        @endif

        {{-- Logika Nomor Halaman --}}
        @php
        $pages = [];

        if ($last <= 3) {
            // Kalau total halaman <=3, tampilkan semua
            $pages=range(1, $last);
            } else {
            // Selalu tampilkan halaman 1 di kiri
            $pages[]=1;

            // Tambahkan ... kalau halaman lebih dari 3
            if ($current> 3) {
            $pages[] = '...';
            }

            // Tampilkan 1 halaman di kiri dan kanan halaman aktif
            $start = max(2, $current - 1);
            $end = min($last - 1, $current + 1);

            // Kalau halaman aktif masih jauh dari halaman terakhir tambahkan ...
            for ($i = $start; $i <= $end; $i++) {
                $pages[]=$i;
                }

                if ($current < $last - 2) {
                $pages[]='...' ;
                }

                // Selalu tampilkan halaman terakhir
                $pages[]=$last;
                }
                @endphp

                @foreach ($pages as $page)
                @if ($page==='...' )
                {{-- ... tidak bisa diklik --}}
                <span style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-right:1px solid #1D2B6B;color:#1D2B6B;font-weight:600;background:white;">
                ...
                </span>
                @elseif ($page == $current)
                {{-- Halaman yang sedang yang aktif warna biru --}}
                <span style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-right:1px solid #1D2B6B;color:white;font-weight:600;background:#1D2B6B;">
                    {{ $page }}
                </span>
                @else
                {{-- Nomor halaman lain yang bisa diklik --}}
                <a href="{{ $paginator->url($page) }}" class="pagination-btn" style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;border-right:1px solid #1D2B6B;color:#1D2B6B;font-weight:600;background:white;text-decoration:none;">
                    {{ $page }}
                </a>
                @endif
                @endforeach

                {{-- Tombol > --}}
                @if ($paginator->hasMorePages())
                {{-- Kalau masih ada halaman berikutnya tombol > bisa diklik --}}
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;color:#1D2B6B;font-weight:600;background:white;text-decoration:none;">
                    &gt;
                </a>
                @else
                {{-- Kalau sudah di halaman terakhir tombol > tidak bisa diklik --}}
                <span style="display:flex;align-items:center;justify-content:center;width:38px;height:38px;color:#1D2B6B;font-weight:600;background:white; cursor:default;">
                    &gt;
                </span>
                @endif

    </div>
</nav>
@endif