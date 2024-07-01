<?php

namespace App\Http\Controllers;

use App\Models\kasM;
use App\Models\pemasukanM;
use App\Models\wargaM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;



class laporanC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $tahun = empty($request->tahun)?date("Y"):$request->tahun;
        return view("pages.admin.laporan", [
            "tahun" => $tahun,
        ]);
    }


    public function laporankas(Request $request)
    {
        $tahun = empty($request->tahun)?date("Y"):$request->tahun;
        return view("pages.admin.laporankas", [
            "tahun" => $tahun,
        ]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetaklaporankas(Request $request)
    {
        $request->validate([
            'tahun'=>'required',
            'bulan'=>'required',
        ]);


        // try{
            $tahun = $request->tahun;
            $bulan = $request->bulan;

            $bulan = date("Y-m", strtotime($tahun."-".$bulan));

            $warga = wargaM::orderBy("namawarga", "asc")->get();

            $data = [];

            foreach ($warga as $item) {
                $cek = kasM::where("idwarga", $item->idwarga)
                ->where("tanggal", "like", "$bulan%")->count();
                $data[] = [
                    "namawarga" => $item->namawarga,
                    "blokrumah" => $item->blokrumah,
                    "status" => $cek,
                ];
            }
            $data = collect($data);

            $lunas = $data->filter(function($data){
                return $data["status"] == 1;
            })->count();
            $belumlunas = $data->filter(function($data){
                return $data["status"] == 0;
            })->count();


            $pdf = PDF::loadView("cetak.laporankas", [
                "data" => $data,
                "bulan" => $bulan,
                "lunas" => $lunas,
                "belumlunas" => $belumlunas,
            ]);

            return $pdf->stream("laporankaswarga.pdf");


        // }catch(\Throwable $th){
        //     return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        // }
    }



    public function cetak(Request $request)
    {
        $request->validate([
            'tanggalawal'=>'required|date',
            'tanggalakhir'=>'required|date',
            // 'keterangan'=>'required',
        ]);


        // try{
            $tanggalawal = date("Y-m-d", strtotime($request->tanggalawal));
            $tanggalakhir = date("Y-m-d", strtotime($request->tanggalakhir));
            $keterangan = "Keuangan";


            $taw = strtotime($tanggalawal);
            $tak = strtotime($tanggalakhir);
            $array = [];

            for ($i=$taw; $i <= $tak ; $i=strtotime("+1 days", $i)) {
                $tanggal = date("Y-m-d", $i);

                $data = pemasukanM::where("tanggal", $tanggal)->get();

                if(count($data) > 0) {
                    $pemasukan = 0;
                    $pengeluaran = 0;
                    foreach ($data as $item) {
                        if ($item->jenispemasukan == "kas") {
                            $pemasukan = $pemasukan + $item->kas->jumlahbayar;
                        }else if($item->jenispemasukan == "tambahan") {
                            $pemasukan = $pemasukan + $item->tambahan->jumlahbayar;
                        }else if ($item->jenispemasukan == "pengeluaran") {
                            $pengeluaran = $pengeluaran + $item->pengeluaran->jumlahkeluar;
                        }

                    }

                    $array[] = [
                        "tanggal" => $tanggal,
                        "pemasukan" => $pemasukan,
                        "pengeluaran" => $pengeluaran,
                    ];
                }

            }

            $data = collect($array);
            // dd($data);

            // if($keterangan == "keseluruhan") {
            //     $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
            //     ->selectRaw()
            //     ->orderBy("tanggal", "asc")
            //     ->get();
            // }else if($keterangan == "pemasukan") {

            //     $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
            //     ->whereIn("jenispemasukan", ["kas", "tambahan"])
            //     ->orderBy("tanggal", "asc")
            //     ->get();
            // }else if($keterangan == "pengeluaran") {
            //     $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
            //     ->where("jenispemasukan", "pengeluaran")
            //     ->orderBy("tanggal", "asc")
            //     ->get();
            // }
            $pdf = PDF::loadView("cetak.laporan", [
                "data" => $data,
                "keterangan" => $keterangan,
                "tanggalawal" => $tanggalawal,
                "tanggalakhir" => $tanggalakhir,
            ]);

            return $pdf->stream($keterangan.".pdf");

        // }catch(\Throwable $th){
        //     return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pemasukanM  $pemasukanM
     * @return \Illuminate\Http\Response
     */
    public function show(pemasukanM $pemasukanM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pemasukanM  $pemasukanM
     * @return \Illuminate\Http\Response
     */
    public function edit(pemasukanM $pemasukanM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pemasukanM  $pemasukanM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pemasukanM $pemasukanM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pemasukanM  $pemasukanM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pemasukanM $pemasukanM)
    {
        //
    }
}
