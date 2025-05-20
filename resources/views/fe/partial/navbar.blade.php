<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap" rel="stylesheet">
<style>
    .text-logo {
        font-family: 'Montserrat', sans-serif;
        font-size: 28px;
        font-weight: 700;
        color: #2b2b2b;
        text-decoration: none;
    }

    .text-logo:hover {
        color: #007bff; /* efek hover */
    }
</style>

  <header class="header-section">
      <div class="container-fluid">
          <div class="inner-header">
              <div class="logo">
                  <a href="{{ route('home.index') }}" class="text-logo">Toko Sehat</a>
              </div>
              <div class="header-right d-flex gap-4 align-items-center">
                  @if (Auth::guard('pelanggan')->check() || isset($user))
                  <!-- User Logged In -->
                  <div class="d-flex align-items-center gap-3">
                      <!-- Profile Icon with Dropdown -->
                      <div class="dropdown position-relative d-none d-md-block">
                          <a href="#" class="dropdown-toggle" id="userDropdown" onclick="toggleDropdown(event)">
                              <img src="{{ asset('storage/' . $user['foto']) }}" alt="User Icon" class="profile-photo">

                          </a>
                          <div class="dropdown-menu" id="dropdownMenu"
                              style="display: none; position: absolute; right: 0; background: white; border: 1px solid #ccc; border-radius: 4px;">
                              <a class="dropdown-item" href="{{ route('profile.index') }}">Profil</a>
                              <form action="{{ route('logout.pelanggan') }}" method="POST">
                                  @csrf
                                  <button type="submit" class="dropdown-item text-danger"
                                      style="background: none; border: none; cursor: pointer;">Logout</button>
                              </form>
                          </div>
                      </div>

                      <!-- Cart Icon -->
                      <a href="{{route('keranjang.index')}}" class="cart-icon position-relative">
                          <img src="{{ asset('fe/img/icons/bag.png') }}" alt="">
                          <span>@if (isset($keranjangs)){{count($keranjangs) | 0}} @endif</span>
                      </a>

                       <a href="{{ route('pesanan.index') }}" class="position-relative d-flex align-items-center">
                      <img src="{{ asset('fe/img/icons/box.svg') }}" alt="Pesanan" style="width: 24px;">
                      @if(isset($pesananAktif) && $pesananAktif)
                      <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle"></span>
                      @endif
                    </a>
                  </div>

                 
                  @else
                  <!-- User Not Logged In -->
                  <div class="user-access">
                      <a href="{{route('getRegister.pelanggan')}}">Daftar</a>
                      <a href="{{route('getLogin.pelanggan')}}" class="in">Masuk</a>
                  </div>
                  @endif
              </div>

              <nav class="main-menu mobile-menu">
                  <ul >
                      <li class="d-md-none"><a href="#">User</a>
                          <ul class="sub-menu">
                              <li><a href="{{ route('profile.index') }}">Profil</a></li>
                              <li>
                                  <form action="{{ route('logout.pelanggan') }}" method="POST">
                                      @csrf
                                      <button type="submit" class="dropdown-item text-danger" style="background: none; border: none; cursor: pointer;">Logout</button>
                                  </form>
                              </li>
                          </ul>
                      </li>
                      <li><a @if(Route::currentRouteName()=='home.index' ) class="active" @endif href="{{ route('home.index') }}">Home</a></li>
                      <li><a @if(Route::currentRouteName()=='produk.index' ) class="active" @endif href="{{ route('produk.index') }}">Shop</a>
                      <li><a @if(Route::currentRouteName()=='about.index' ) class="active" @endif href="{{ route('about.index') }}">About</a></li>
                      <li><a @if(Route::currentRouteName()=='contact.index' ) class="active" @endif href="{{ route('contact.index') }}">Contact</a></li>
                  </ul>
              </nav>
          </div>
      </div>
  </header>

  <!-- script profile dropdown -->
  <script>
      function toggleDropdown(event) {
          event.preventDefault();
          const menu = document.getElementById('dropdownMenu');
          menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
      }

      // Optional: hide dropdown if user clicks outside
      document.addEventListener('click', function(e) {
          const toggle = document.getElementById('userDropdown');
          const menu = document.getElementById('dropdownMenu');
          if (!toggle.contains(e.target) && !menu.contains(e.target)) {
              menu.style.display = 'none';
          }
      });
  </script>