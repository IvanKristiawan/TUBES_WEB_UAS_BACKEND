<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;

use function PHPUnit\Framework\returnSelf;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reviews = Review::all();

        if (count($reviews) > 0) {
            return response([
                'message' => 'Retrieve All Success',
                'data' => $reviews
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
            'idUser' => 'required|max:100',
            'namaUser' => 'required|max:100',
            'rating' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $review = Review::create($storeData);
        return response([
            'message' => 'Add review Success',
            'data' => $review
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
        $review = Review::find($id);

        if (!is_null($review)) {
            return response([
                'message' => 'Retrieve review Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'review Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdUser($id)
    {
        $review = Review::where('idUser', $id)->get();

        if (!is_null($review)) {
            return response([
                'message' => 'Retrieve review by id user Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'review Not Found',
            'data' => null
        ], 404);
    }

    public function showAllByIdBarang($id)
    {
        $review = Review::where('idBarang', $id)->get();

        if (!is_null($review)) {
            return response([
                'message' => 'Retrieve review by id barang Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'review Not Found',
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
        $review = Review::find($id);
        if (is_null($review)) {
            return response([
                'message' => 'review Not Found',
                'data' => null
            ], 404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData, [
            'rating' => 'required|numeric'
        ]);

        if ($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $review->rating = $updateData['rating'];

        if ($review->save()) {
            return response([
                'message' => 'Update review Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'Update review Failed',
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
        $review = Review::find($id);

        if (is_null($review)) {
            return response([
                'message' => 'review Not Found',
                'data' => null
            ], 404);
        }

        if ($review->delete()) {
            return response([
                'message' => 'Delete review Success',
                'data' => $review
            ], 200);
        }

        return response([
            'message' => 'Delete review Failed',
            'data' => null
        ], 400);
    }
}
