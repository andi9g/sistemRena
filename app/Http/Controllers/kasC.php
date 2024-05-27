<?php

namespace App\Http\Controllers;

use App\Models\kasM;
use App\Models\wargaM;
use App\Models\pemasukanM;
use App\Models\jumlahbayarM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class kasC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;

        $title = "Delete";
        $text = "Are you sure?";

        confirmDelete($title, $text);

        $warga = wargaM::where("namawarga", "like", "%$keyword%")
        ->orWhere("blokrumah", "like", "%$keyword%")
        ->orderBy("idwarga", "desc")
        ->paginate(15);

        $warga->appends($request->only(['limit', 'keyword']));


        return view("pages.admin.kas", [
            "warga" => $warga,
            "keyword" => $keyword,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun'=>'required',
            'bulan'=>'required',
            'tanggal'=>'required',
            'jumlahbayar'=>'required',
            'keterangan'=>'required',
        ]);

        try{

            $cek = kasM::where("idwarga", $request->idwarga)
            ->where("bulan", $request->idwarga)
            ->where("tahun", $request->tahun)
            ->count();

            if($cek ==1) {
                return redirect()->back()->with('error', 'Data pembayaran sudah ada!');
            }

            $data = $request->all();

            $pemasukan = pemasukanM::create([
                "jenispemasukan" => "kas",
                "tanggal" => $request->tanggal,
            ]);

            $data["idpemasukan"] = $pemasukan->idpemasukan;

            kasM::create($data);
            return redirect()->back()->with('success', 'Success');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\kasM  $kasM
     * @return \Illuminate\Http\Response
     */
    public function show(kasM $kasM, $idwarga)
    {
        $tahun = date("Y");

        $bulan = [];
        for ($i=1; $i <= 12; $i++) {
            $date = Carbon::createFromDate(null, $i);
            $namabulan = $date->isoFormat('MMMM');
            $cek = kasM::where("bulan", $namabulan)->where("tahun", $tahun)->where("idwarga", $idwarga)
            ->count();
            if($cek == 0) {
                $bulan[] = $namabulan;
            }
        }

        $title = "Hapus data";
        $text = "Yakin ingin dihapus?";
        confirmDelete($title, $text);

        $warga = wargaM::where("idwarga", $idwarga)->first();

        $kas = kasM::where("idwarga", $idwarga)->where("tahun", $tahun)
        ->orderBy('tanggal', 'asc')
        ->get();

        return view("pages.admin.detailkas", [
            "warga" => $warga,
            "kas" => $kas,
            "bulan" => $bulan,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\kasM  $kasM
     * @return \Illuminate\Http\Response
     */
    public function edit(kasM $kasM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\kasM  $kasM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, kasM $kasM, $idkas)
    {
        $request->validate([
            'tanggal'=>'required',
            'jumlahbayar'=>'required',
            'keterangan'=>'required',
        ]);

        try{

            $data = $request->all();

            $kasM->findOrFail($idkas)->update($data);
            return redirect()->back()->with('success', 'Success');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\kasM  $kasM
     * @return \Illuminate\Http\Response
     */
    public function destroy(kasM $kasM, $idkas)
    {
        try{
            $data = kasM::where("idkas", $idkas)->first();

            pemasukanM::where("idpemasukan", $data->idpemasukan)->delete();
            kasM::destroy($idkas);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
