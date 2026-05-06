<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carent - Rental Mobil</title>
</head>
<body>

    {{-- SECTION: HERO --}}
    <section>
        <h1>Temukan Mobil Terbaik untuk Perjalananmu</h1>
        <p>Rental mobil terpercaya dengan harga terbaik</p>

        {{-- Form Cari Mobil --}}

    </section>

    {{-- SECTION: MOBIL TERBARU --}}
    <section>
        <h2>Mobil Tersedia</h2>

        @forelse ($mobilTerbaru as $mobil)
            <div>
                {{-- Foto Mobil --}}
                @if ($mobil->fotoPrimary)
                    <img src="{{ asset('storage/' . $mobil->fotoPrimary->url_foto) }}"
                         alt="{{ $mobil->nama_mobil }}">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="Tidak ada foto">
                @endif

                {{-- Info Mobil --}}
                <h3>{{ $mobil->nama_mobil }}</h3>
                <p>{{ $mobil->transmisi }} • {{ $mobil->kapasitas_penumpang }} kursi</p>
                <p>Rp {{ number_format($mobil->harga_per_hari, 0, ',', '.') }} / hari</p>
                <p>{{ $mobil->rental->nama_rental }}</p>

            </div>
        @empty
            <p>Belum ada mobil tersedia.</p>
        @endforelse
    </section>

    {{-- SECTION: RENTAL TERDAFTAR --}}
    <section>
        <h2>Rental Terdaftar</h2>

        @forelse ($rentalAktif as $rental)
            <div>
                @if ($rental->logo_perusahaan)
                    <img src="{{ asset('storage/' . $rental->logo_perusahaan) }}"
                         alt="{{ $rental->nama_rental }}">
                @endif

                <h3>{{ $rental->nama_rental }}</h3>
                <p>{{ $rental->kota }}</p>
                <p>{{ $rental->mobils_count }} mobil tersedia</p>

            </div>
        @empty
            <p>Belum ada rental terdaftar.</p>
        @endforelse
    </section>

</body>
</html>