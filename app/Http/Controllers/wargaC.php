<?php

namespace App\Http\Controllers;

use App\Models\wargaM;
use Illuminate\Http\Request;

class wargaC extends Controller
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
        ->orWhere("blokrumah", "like", "$keyword%")
        ->orderBy("idwarga", "desc")
        ->paginate(15);

        $warga->appends($request->only(['limit', 'keyword']));


        return view("pages.admin.warga", [
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
            'namawarga'=>'required',
            'blokrumah'=>'required',
        ]);

        try{
            $data = $request->all();
            wargaM::create($data);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\wargaM  $wargaM
     * @return \Illuminate\Http\Response
     */
    public function show(wargaM $wargaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\wargaM  $wargaM
     * @return \Illuminate\Http\Response
     */
    public function edit(wargaM $wargaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\wargaM  $wargaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, wargaM $wargaM, $idwarga)
    {
        $request->validate([
            'namawarga'=>'required',
            'blokrumah'=>'required',
        ]);

        try{
            $data = $request->all();
            wargaM::where("idwarga", $idwarga)->first()->update($data);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\wargaM  $wargaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(wargaM $wargaM, $idwarga)
    {
        try{
            wargaM::destroy($idwarga);
            return redirect()->back()->with('success', 'Success');
        }catch(\Throwable $th){
            return redirect()->back()->with('toast_error', 'Terjadi kesalahan');
        }
    }
}
