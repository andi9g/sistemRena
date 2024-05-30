<?php

namespace App\Http\Controllers;

use App\Models\pemasukanM;
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cetak(Request $request)
    {
        $request->validate([
            'tanggalawal'=>'required|date',
            'tanggalakhir'=>'required|date',
            'keterangan'=>'required',
        ]);


        // try{
            $tanggalawal = date("Y-m-d H:i:s", strtotime($request->tanggalawal." 05:00:00"));
            $tanggalakhir = date("Y-m-d H:i:s", strtotime($request->tanggalakhir." 23:59:00"));
            $keterangan = $request->keterangan;

            if($keterangan == "keseluruhan") {
                $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
                ->orderBy("tanggal", "asc")
                ->get();
            }else if($keterangan == "pemasukan") {

                $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
                ->whereIn("jenispemasukan", ["kas", "tambahan"])
                ->orderBy("tanggal", "asc")
                ->get();
            }else if($keterangan == "pengeluaran") {
                $data = pemasukanM::whereBetween("tanggal", [$tanggalawal, $tanggalakhir])
                ->where("jenispemasukan", "pengeluaran")
                ->orderBy("tanggal", "asc")
                ->get();

            }
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
