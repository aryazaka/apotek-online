<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penjualan', function (Blueprint $table) {
            $table->id(); 
            $table->string('kode_transaksi', 255)->nullable();
            $table->string('snap_token', 255)->nullable();
            $table->foreignId('id_metode_bayar')->nullable()->constrained('metode_bayar')->onDelete('cascade');
            $table->date('tgl_penjualan');
            $table->string('url_resep', 255)->nullable();
            $table->decimal('ongkos_kirim', 10, 2)->default(0);
            $table->decimal('biaya_app', 10, 2)->default(0);
            $table->decimal('total_bayar', 10, 2)->default(0);
            $table->enum('status_order', [
                'Menunggu Konfirmasi',
                'Diproses',
                'Menunggu Kurir',
                'Dalam Pengiriman',
                'Dibatalkan Pembeli',
                'Dibatalkan Penjual',
                'Bermasalah',
                'Selesai'
            ])->default('Menunggu Konfirmasi');
            $table->string('keterangan_status', 255)->nullable();
            $table->foreignId('id_jenis_kirim')->constrained('jenis_pengiriman')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->constrained('pelanggan')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
