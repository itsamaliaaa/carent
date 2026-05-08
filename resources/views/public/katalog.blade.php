<section class="armada">
  <div class="container">
    <div class="armada-list">

      @isset($cars)
        @foreach($cars as $car)
          <div class="car-card">
            <div class="card-image">
              <img src="{{ asset($car->image) }}" alt="{{ $car->name }}" />

              @if($car->status == 'Tersedia')
                <span class="badge">Tersedia</span>
              @else
                <span class="badge-rent">Disewa</span>
              @endif
            </div>

            <div class="card-body">
              <h3>{{ $car->name }}</h3>

              <div class="rating">
                <span class="stars">
                  @for($i = 1; $i <= 5; $i++)
                    {{ $i <= round($car->rating) ? '★' : '☆' }}
                  @endfor
                </span>
                <span class="rate">{{ number_format($car->rating, 1) }}</span>
                <span class="review">({{ $car->reviews_count }} ulasan)</span>
              </div>

              <p class="spec">{{ $car->transmission }} · {{ $car->seats }} Kursi</p>

              <div class="price">
                <span class="mulai">Mulai dari</span>
                <span class="harga">Rp {{ number_format($car->price_per_day / 1000, 0) }}k/hari</span>
              </div>

              <div class="card-btn">
                <a href="{{ $car->detail_url ?? '#' }}" class="btn-card">Lihat Detail</a>

                @if($car->status == 'Tersedia')
                  <a href="{{ $car->booking_url ?? '#' }}" class="btn-card">Booking</a>
                @else
                  <a href="#" class="btn-card-rent" onclick="return false;">Booking</a>
                @endif
              </div>
            </div>
          </div>
        @endforeach
      @else
        <p>No cars available at the moment.</p>
      @endisset

    </div>
  </div>
</section>
