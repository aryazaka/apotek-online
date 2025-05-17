<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
        <div class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top">
          <a class="sidebar-brand brand-logo" href="{{ route('dashboard.index') }}"><img src="{{ asset('be/assets/images/logo.svg') }}" alt="logo" /></a>
          <a class="sidebar-brand brand-logo-mini" href="{{ route('dashboard.index') }}"><img src="{{ asset('be/assets/images/logo-mini.svg') }}" alt="logo" /></a>
        </div>
        <ul class="nav">
          <li class="nav-item profile">
            <div class="profile-desc">
              <div class="profile-pic">
                <div class="count-indicator">
                  <img class="img-xs rounded-circle" src="{{ asset('be/assets/images/faces/face15.jpg') }}" alt="">
                  <span class="count bg-success"></span>
                </div>
                <div class="profile-name">
                  <h5 class="mb-0 font-weight-normal">{{ Auth::user()->name }}</h5>
                  <span>{{ Auth::user()->jabatan }}</span>
                </div>
              </div>
              <a href="#" id="profile-dropdown" data-toggle="dropdown"><i class="mdi mdi-dots-vertical"></i></a>
              <div class="dropdown-menu dropdown-menu-right sidebar-dropdown preview-list" aria-labelledby="profile-dropdown">
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-settings text-primary"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Account settings</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-onepassword text-info"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">Change Password</p>
                  </div>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item preview-item">
                  <div class="preview-thumbnail">
                    <div class="preview-icon bg-dark rounded-circle">
                      <i class="mdi mdi-calendar-today text-success"></i>
                    </div>
                  </div>
                  <div class="preview-item-content">
                    <p class="preview-subject ellipsis mb-1 text-small">To-do list</p>
                  </div>
                </a>
              </div>
            </div>
          </li>


          <li class="nav-item nav-category">
            <span class="nav-link">Navigation</span>
          </li>
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('dashboard.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-speedometer"></i>
              </span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          @if (in_array(Auth::user()->jabatan, ['karyawan','apoteker','kasir']))
          <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#produk" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-table-large"></i>
              </span>
              <span class="menu-title">Produk</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="produk">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{route('obat.index')}}">Obat</a></li>
                @if (Auth::user()->jabatan === 'karyawan')
                <li class="nav-item"> <a class="nav-link" href="{{ route('jenis.index') }}">Jenis Obat</a></li>
                @endif
                
              </ul>
            </div>
          </li>
          @endif
          

            @if(Auth::user()->jabatan === 'pemilik')
            <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-note"></i>
              </span>
              <span class="menu-title">Laporan</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="laporan">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('laporan.penjualan.index') }}">Penjualan</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('laporan.pembelian.index') }}">Pembelian</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('laporan.pelanggan.index') }}">Pelanggan</a></li>

              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->jabatan === 'admin')
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('users.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple"></i>
              </span>
              <span class="menu-title">Manage Users</span>
            </a>
          </li>

            <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('pelanggans.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-account-multiple-outline"></i>
              </span>
              <span class="menu-title">Manage Pelanggan</span>
            </a>
          </li>
           @endif

          @if (in_array(Auth::user()->jabatan , ['karyawan','kasir']))
              <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('penjualan.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-cash-multiple"></i>
              </span>
              <span class="menu-title">Penjualan Produk</span>
            </a>
          </li>
          @endif
      
          @if (Auth::user()->jabatan === 'apoteker')
            <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('distributor.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-codepen"></i>
              </span>
              <span class="menu-title">Distributor</span>
            </a>
          </li>

           <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('pembelian.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-cart"></i>
              </span>
              <span class="menu-title">Pembelian Produk</span>
            </a>
          </li>
          @endif

          @if (Auth::user()->jabatan === 'kurir')
          <li class="nav-item menu-items">
            <a class="nav-link" href="{{ route('jenis-pengiriman.index') }}">
              <span class="menu-icon">
                <i class="mdi mdi-truck"></i>
              </span>
              <span class="menu-title">Jenis Pengiriman</span>
            </a>
          </li>
          @endif
     

  

          <!-- <li class="nav-item menu-items">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <span class="menu-icon">
                <i class="mdi mdi-laptop"></i>
              </span>
              <span class="menu-title">Produk</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Dropdowns</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li> -->
          
          
      </nav>
      <!-- partial -->