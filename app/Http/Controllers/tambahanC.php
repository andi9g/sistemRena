<?php

namespace App\Http\Controllers;

use App\Models\tambahanM;
use App\Models\kasM;
use App\Models\wargaM;
use App\Models\pemasukanM;
use App\Models\jumlahbayarM;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class tambahanC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?'':$request->keyword;

        $tambahan = tambahanM::where("nama", "like", "%$keyword%")
        ->orderBy("tanggal", 'desc')
        ->paginate(15);

        $tambahan->appends($request->only(['limit', 'keyword']));

        return view('pages.admin.tambahan', [
            'keyword' => $keyword,
            'tambahan' => $tambahan,
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
            'nama'=>'required',
            'tanggal'=>'required|date',
            'jumlahbayar'=>'required|numeric',
            'perincian'=>'required',
            'keterangan'=>'required',
        ]);

        try{

            $data = $request->all();

            $pemasukan = pemasukanM::create([
                "jenispemasukan" => "tambahan",
                "tanggal" => $request->tanggal,
            ]);

            $data["idpemasukan"] = $pemasukan->idpemasukan;

            tambahanM::create($data);
            return redirect()->back()->with('success', 'Success');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tambahanM  $tambahanM
     * @return \Illuminate\Http\Response
     */
    public function show(tambahanM $tambahanM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tambahanM  $tambahanM
     * @return \Illuminate\Http\Response
     */
    public function edit(tambahanM $tambahanM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tambahanM  $tambahanM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tambahanM $tambahanM,$idtambahan)
    {
        $request->validate([
            'nama'=>'required',
            'tanggal'=>'required|date',
            'jumlahbayar'=>'required|numeric',
            'perincian'=>'required',
            'keterangan'=>'required',
        ]);

        try{

            $data = $request->all();

            tambahanM::findOrFail($idtambahan)->update($data);
            return redirect()->back()->with('success', 'Success');

        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tambahanM  $tambahanM
     * @return \Illuminate\Http\Response
     */
    public function destroy(tambahanM $tambahanM, $idtambahan)
    {
        try{
            $data = tambahanM::where("idtambahan", $idtambahan)->first();

            pemasukanM::where("idpemasukan", $data->idpemasukan)->delete();
            tambahanM::destroy($idtambahan);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
