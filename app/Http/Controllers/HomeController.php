<?php

namespace App\Http\Controllers;

use App\Models\pemasukanM;
use App\Models\kasM;
use App\Models\wargaM;
use App\Models\pengeluaranM;
use App\Models\tambahanM;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $tahun = empty($request->tahun)?date("Y"):$request->tahun;


        if($tahun == "keseluruhan") {
            $pemasukan = pemasukanM::orderBy('idpemasukan', 'desc')->paginate(15);
            $pemasukanKas = pemasukanM::where("jenispemasukan", "kas")->get();
            $pemasukanTambahan = pemasukanM::where("jenispemasukan", "tambahan")->get();
            $pemasukanPengeluaran = pemasukanM::where("jenispemasukan", "pengeluaran")->get();
        }else {
            $pemasukan = pemasukanM::orderBy('idpemasukan', 'desc')->where("tanggal", "like", "$tahun%")->paginate(15);
            $pemasukanKas = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "kas")
            ->get();
            $pemasukanTambahan = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "tambahan")
            ->get();
            $pemasukanPengeluaran = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "pengeluaran")
            ->get();
        }

        $pemasukan->appends($request->only(["limit", "tahun"]));

        $kas = 0;
        $tambahan = 0;
        $pengeluaran = 0;

        foreach ($pemasukanKas as $pk) {
            $kas = $kas + $pk->kas->jumlahbayar;
        }

        foreach ($pemasukanTambahan as $pt) {
            $tambahan = $tambahan + $pt->tambahan->jumlahbayar;
        }
        foreach ($pemasukanPengeluaran as $pp) {
            $pengeluaran = $pengeluaran + $pp->pengeluaran->jumlahkeluar;
        }

        $totalkeuangan = $kas + $tambahan - $pengeluaran;

        return view('pages.admin.home', [
            "kas" => $kas,
            "pemasukan" => $pemasukan,
            "tambahan" => $tambahan,
            "pengeluaran" => $pengeluaran,
            "totalkeuangan" => $totalkeuangan,
            "tahun" => $tahun,
        ]);
    }
    public function umum(Request $request)
    {
        $tahun = empty($request->tahun)?date("Y"):$request->tahun;


        if($tahun == "keseluruhan") {
            $pemasukan = pemasukanM::orderBy('idpemasukan', 'desc')->paginate(15);
            $pemasukanKas = pemasukanM::where("jenispemasukan", "kas")->get();
            $pemasukanTambahan = pemasukanM::where("jenispemasukan", "tambahan")->get();
            $pemasukanPengeluaran = pemasukanM::where("jenispemasukan", "pengeluaran")->get();
        }else {
            $pemasukan = pemasukanM::orderBy('idpemasukan', 'desc')->where("tanggal", "like", "$tahun%")->paginate(15);
            $pemasukanKas = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "kas")
            ->get();
            $pemasukanTambahan = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "tambahan")
            ->get();
            $pemasukanPengeluaran = pemasukanM::where("tanggal", "like", "$tahun%")
            ->where("jenispemasukan", "pengeluaran")
            ->get();
        }

        $pemasukan->appends($request->only(["limit", "tahun"]));

        $kas = 0;
        $tambahan = 0;
        $pengeluaran = 0;

        foreach ($pemasukanKas as $pk) {
            $kas = $kas + $pk->kas->jumlahbayar;
        }

        foreach ($pemasukanTambahan as $pt) {
            $tambahan = $tambahan + $pt->tambahan->jumlahbayar;
        }
        foreach ($pemasukanPengeluaran as $pp) {
            $pengeluaran = $pengeluaran + $pp->pengeluaran->jumlahkeluar;
        }

        $totalkeuangan = $kas + $tambahan - $pengeluaran;

        $keyword = empty($request->keyword)?'':$request->keyword;


        $warga = wargaM::where("namawarga", "like", "%$keyword%")
        ->orWhere("blokrumah", "like", "%$keyword%")
        ->orderBy("idwarga", "desc")
        ->paginate(15);

        $warga->appends($request->only(['limit', 'keyword']));

        return view('pages.admin.umum', [
            "kas" => $kas,
            "pemasukan" => $pemasukan,
            "tambahan" => $tambahan,
            "pengeluaran" => $pengeluaran,
            "totalkeuangan" => $totalkeuangan,
            "tahun" => $tahun,
            "warga" => $warga,
            "keyword" => $keyword,
        ]);
    }
}
