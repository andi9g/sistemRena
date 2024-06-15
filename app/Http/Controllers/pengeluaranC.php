<?php

namespace App\Http\Controllers;

use App\Models\pengeluaranM;
use App\Models\tambahanM;
use App\Models\kasM;
use App\Models\wargaM;
use App\Models\pemasukanM;
use App\Models\jumlahbayarM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class pengeluaranC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;

        $pengeluaran = pengeluaranM::where("perincian", "like", "%$keyword%")
        ->orderBy("tanggal", 'desc')
        ->paginate(15);

        $pengeluaran->appends($request->only(['limit', 'keyword']));

        return view('pages.admin.pengeluaran', [
            'keyword' => $keyword,
            'pengeluaran' => $pengeluaran,
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
            'tanggal'=>'required|date',
            'jumlahkeluar'=>'required|numeric',
            'perincian'=>'required',
        ]);

        try{


            $pemasukanKas = pemasukanM::where("jenispemasukan", "kas")->get();
            $pemasukanTambahan = pemasukanM::where("jenispemasukan", "tambahan")->get();
            $pemasukanPengeluaran = pemasukanM::where("jenispemasukan", "pengeluaran")->get();



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

            if($totalkeuangan <= $request->jumlahkeluar) {

                $data = $request->all();

                $pemasukan = pemasukanM::create([
                    "jenispemasukan" => "pengeluaran",
                    "tanggal" => $request->tanggal,
                ]);

                $data["idpemasukan"] = $pemasukan->idpemasukan;

                pengeluaranM::create($data);
                return redirect()->back()->with('success', 'Success');
            }else {
                return redirect()->back()->with('toast_error', 'Maaf jumlah uang kurang');

            }


        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pengeluaranM  $pengeluaranM
     * @return \Illuminate\Http\Response
     */
    public function show(pengeluaranM $pengeluaranM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pengeluaranM  $pengeluaranM
     * @return \Illuminate\Http\Response
     */
    public function edit(pengeluaranM $pengeluaranM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\pengeluaranM  $pengeluaranM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pengeluaranM $pengeluaranM, $idpengeluaran)
    {
        $request->validate([
            'tanggal'=>'required|date',
            'jumlahkeluar'=>'required|numeric',
            'perincian'=>'required',
        ]);

        try{
            $data = $request->all();
            pengeluaranM::findOrFail($idpengeluaran)->update($data);
            return redirect()->back()->with('success', 'Success');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pengeluaranM  $pengeluaranM
     * @return \Illuminate\Http\Response
     */
    public function destroy(pengeluaranM $pengeluaranM, $idpengeluaran)
    {
        try{
            $data = pengeluaranM::where("idpengeluaran", $idpengeluaran)->first();

            pemasukanM::where("idpemasukan", $data->idpemasukan)->delete();
            pengeluaranM::destroy($idpengeluaran);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
