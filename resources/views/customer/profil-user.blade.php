<section class="armada">
        <div class="container">
          <div class="armada-list">

            @foreach($mobils as $mobil)
              <div class="car-card">
                <div class="card-image">
                  <img
                    src="{{ $mobil->fotoPrimary ? asset('storage/' . $mobil->fotoPrimary->path) : asset('assets/images/default-car.jpg') }}"
                    alt="{{ $mobil->nama_mobil }}"
                  />
                  <span class="badge {{ strtolower($mobil->status) === 'tersedia' ? '' : 'badge-rent' }}">
                    {{ ucfirst($mobil->status) }}
                  </span>
                </div>

                <div class="card-body">
                  <h3>{{ $mobil->nama_mobil }} {{ $mobil->tahun }}</h3>

                  <div class="rating">
                    <span class="stars">
                      @php $rating = $mobil->rating ?? 0; @endphp
                      @for($i = 1; $i <= 5; $i++)
                        {{ $i <= round($rating) ? '★' : '☆' }}
                      @endfor
                    </span>
                    <span class="rate">{{ number_format($rating, 1) }}</span>
                    <span class="review">({{ $mobil->bookings()->whereHas('review')->count() }} ulasan)</span>
                  </div>

                  <p class="spec">{{ ucfirst($mobil->transmisi) }} · {{ $mobil->kapasitas_penumpang }} Kursi</p>

                  <div class="price">
                    <span class="mulai">Mulai dari</span>
                    <span class="harga">Rp {{ number_format($mobil->harga_per_hari / 1000, 0) }}k/hari</span>
                  </div>

                  <div class="card-btn">
                    <a href="{{ route('katalog.detail', $mobil->mobil_id) }}" class="btn-card">Lihat Detail</a>

                    @if(strtolower($mobil->status) === 'tersedia')
                      <a href="{{ route('booking.create', $mobil->mobil_id) }}" class="btn-card">Booking</a>
                    @else
                      <a href="#" class="btn-card-rent" onclick="return false;" style="cursor: not-allowed;">Booking</a>
                    @endif
                  </div>
                </div>
              </div>
            @endforeach

          </div>
        </div>
      </section>
