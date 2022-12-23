<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\mahasiswa;
class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mahasiswa = mahasiswa::All();
        return view('showMahasiswa', compact('mahasiswa'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inputMahasiswa');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'nim'=>'required|integer|min:99999',
            'nama'=>'required|min:3',
            'alamat'=>'required|min:5',
            'birthdate'=>'required',
            'foto'=>'required|mimes:jpg,png,jpeg'
        ]);

        $extension = $request->file('foto')->getClientOriginalExtension();
        $filename = $request->nim.'_'.$request->image.'.'.$extension;
        $request->file('foto')->storeAs('/public/mahasiswa', $filename);

        mahasiswa::create([
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'foto'=>$filename,  
            'birthdate'=>$request->birthdate
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $mahasiswa = mahasiswa::findOrFail($id);

        return view('detailMahasiswa', compact('mahasiswa'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mahasiswa = mahasiswa::findOrFail($id);

        return view('editMahasiswa', compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $extension = $request->file('foto')->getClientOriginalExtension();
        $filename = $request->nim.'_'.$request->nim.'.'.$extension;
        $request->file('foto')->storeAs('/public/mahasiswa', $filename);

        mahasiswa::findOrFail($id)->update([
            'nim'=>$request->nim,
            'nama'=>$request->nama,
            'alamat'=>$request->alamat,
            'foto'=>$filename,  
            'birthdate'=>$request->birthdate
        ]);

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        mahasiswa::destroy($id);

        return redirect('/');
    }
}
