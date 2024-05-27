<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Bendahara extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jumlahbayar', function (Blueprint $table) {
            $table->bigIncrements('idjumlahbayar');
            $table->double('jumlahbayar');
            $table->timestamps();
        });

        DB::table("jumlahbayar")->insert([
            "jumlahbayar" => 360000,
        ]);

        Schema::create('warga', function (Blueprint $table) {
            $table->bigIncrements('idwarga');
            $table->String('namawarga');
            $table->String('blokrumah');
            $table->timestamps();
        });

        Schema::create('pemasukan', function (Blueprint $table) {
            $table->bigIncrements('idpemasukan');
            $table->enum('jenispemasukan', ['kas', 'tambahan', 'pengeluaran']);
            $table->date("tanggal");
            $table->timestamps();
        });

        Schema::create('kas', function (Blueprint $table) {
            $table->bigIncrements('idkas');
            $table->integer('idpemasukan');
            $table->String('idwarga');
            $table->String('bulan');
            $table->date('tanggal');
            $table->double('jumlahbayar');
            $table->enum('keterangan', ['lunas', 'belum lunas']);
            $table->timestamps();
        });

        Schema::create('tambahan', function (Blueprint $table) {
            $table->bigIncrements('idtambahan');
            $table->integer('idpemasukan');
            $table->String('nama');
            $table->date('tanggal');
            $table->longText('perincian');
            $table->double('jumlahbayar');
            $table->enum('keterangan', ['lunas', 'belum lunas']);
            $table->timestamps();
        });

        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->bigIncrements('idpengeluaran');
            $table->integer('idpemasukan');
            $table->double('jumlahkeluar');
            $table->date('tanggal');
            $table->longText('perincian');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
