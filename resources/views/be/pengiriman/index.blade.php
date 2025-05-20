@extends('be/partial/master')
@section('navbar')
    @include('be/partial/navbar')
@endsection
@section('sidebar')
    @include('be/partial/sidebar')
@endsection
@section('footer')
    @include('be/partial/footer')
@endsection

@section('content')
<div class="px-4">
  <!-- Tab Navigation -->
  <ul class="nav nav-tabs mb-3" id="pengirimanTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="belum-tab" data-bs-toggle="tab" data-bs-target="#belum" type="button" role="tab">
        Belum Diambil Kurir
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="dalam-tab" data-bs-toggle="tab" data-bs-target="#dalam" type="button" role="tab">
        Dalam Pengiriman
      </button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="pengirimanTabContent">
    <!-- Tab Belum Diambil -->
    <div class="tab-pane fade show active" id="belum" role="tabpanel">
      @include('be.pengiriman.belumDiambil', ['penjualans' => $penjualans])
    </div>

    <!-- Tab Dalam Pengiriman -->
    <div class="tab-pane fade" id="dalam" role="tabpanel">
      @include('be.pengiriman.dalamPengiriman', ['pengirimans' => $pengirimanList])
    </div>
  </div>
</div>
@endsection