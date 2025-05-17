@extends('fe.partial.master')

@section('content')
<div class="container py-5">
    <h4>Proses Pembayaran</h4>
    <button id="pay-button" class="btn btn-primary">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    var payButton = document.getElementById('pay-button');
    payButton.addEventListener('click', function () {
        window.snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                window.location.href = '{{ route("checkout.sukses", $penjualan->id) }}';
            },
            onPending: function(result) {
                window.location.href = '{{ route("checkout.pending", $penjualan->id) }}';
            },
            onError: function(result) {
                alert("Terjadi kesalahan saat memproses pembayaran.");
            }
        });
    });
</script>
@endsection
