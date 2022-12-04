<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;

use function PHPUnit\Framework\returnSelf;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangs = Barang::all();

        if (count($barangs) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $barangs
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
            'namaBarang' => 'required|max:100',
            'jumlahBarang' => 'required|numeric',
            'hargaBarang' => 'required|numeric',
            'deskripsiBarang' => 'required|max:100',
            'gambarBarang' => 'required|max:100',
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $barang = Barang::create($storeData);
        return response([
            'message' => 'Add barang Success',
            'data' => $barang
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
        $barang = Barang::find($id);

        if (!is_null($barang)) {
            return response([
                'message' => 'Retrieve barang Success',
                'data' => $barang
            ], 200);
        }

        return response([
            'message' => 'barang Not Found',
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
        $barang = Barang::find($id);
        if (is_null($barang)) {
            return response([
                'message' => 'barang Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'namaBarang' => 'required',
            'jumlahBarang' => 'required|numeric',
            'hargaBarang' => 'required|numeric',
            'deskripsiBarang' => 'required',
            'gambarBarang' => 'required'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $barang->namaBarang = $updateData['namaBarang'];
        $barang->jumlahBarang = $updateData['jumlahBarang'];
        $barang->hargaBarang = $updateData['hargaBarang'];
        $barang->deskripsiBarang = $updateData['deskripsiBarang'];
        $barang->gambarBarang = $updateData['gambarBarang'];

        if ($barang->save()) {
            return response([
                'message' => 'Update barang Success',
                'data' => $barang
            ], 200);
        }

        return response([
            'message' => 'Update barang Failed',
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
        $barang = Barang::find($id);

        if (is_null($barang)) {
            return response([
                'message' => 'barang Not Found',
                'data' => null
            ], 404);
        }

        if ($barang->delete()) {
            return response([
                'message' => 'Delete barang Success',
                'data' => $barang
            ], 200);
        }

        return response([
            'message' => 'Delete barang Failed',
            'data' => null
        ], 400);
    }
}
