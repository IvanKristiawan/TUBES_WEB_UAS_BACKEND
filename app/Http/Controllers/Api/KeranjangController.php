<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Keranjang;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $keranjangs = Keranjang::all();

        if (count($keranjangs) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $keranjangs
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
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
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'idBarang' => 'required|max:100',
            'namaBarang' => 'required|max:100',
            'idUser' => 'required|max:100',
            'gambarBarang' => 'required|max:100',
            'kuantitas' => 'required|numeric',
            'hargaBarang' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $keranjang = Keranjang::create($storeData);
        return response([
            'message' => 'Add keranjang Success',
            'data' => $keranjang
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $keranjang = Keranjang::find($id);

        if (!is_null($keranjang)) {
            return response([
                'message' => 'Retrieve keranjang Success',
                'data' => $keranjang
            ], 200);
        }

        return response([
            'message' => 'keranjang Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdUser($id)
    {
        $keranjang = Keranjang::where('idUser', $id)->get();

        if (!is_null($keranjang)) {
            return response([
                'message' => 'Retrieve keranjang by id user Success',
                'data' => $keranjang
            ], 200);
        }

        return response([
            'message' => 'keranjang Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdBarang($id)
    {
        $keranjang = Keranjang::where('idBarang', $id)->get();

        if (!is_null($keranjang)) {
            return response([
                'message' => 'Retrieve keranjang by id barang Success',
                'data' => $keranjang
            ], 200);
        }

        return response([
            'message' => 'keranjang Not Found',
            'data' => null
        ], 404);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $keranjang = Keranjang::find($id);
        if (is_null($keranjang)) {
            return response([
                'message' => 'keranjang Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'kuantitas' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $keranjang->kuantitas = $updateData['kuantitas'];

        if ($keranjang->save()) {
            return response([
                'message' => 'Update keranjang Success',
                'data' => $keranjang
            ], 200);
        }

        return response([
            'message' => 'Update keranjang Failed',
            'data' => null
        ], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $keranjang = Keranjang::find($id);

        if (is_null($keranjang)) {
            return response([
                'message' => 'keranjang Not Found',
                'data' => null
            ], 404);
        }

        if ($keranjang->delete()) {
            return response([
                'message' => 'Delete keranjang Success',
                'data' => $keranjang
            ], 200);
        }

        return response([
            'message' => 'Delete keranjang Failed',
            'data' => null
        ], 400);
    }
}
