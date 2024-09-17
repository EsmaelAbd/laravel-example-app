<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Http\Requests\updateBrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brand = Brand::with(['products'  => function ($q) { // the q stands for query
            $q->where('price', '>=', 1000);
        }])->get();
        return response()->json([
            'status' => 'success',
            'brand' => $brand,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $brand = Brand::create($request->all());
        return response()->json($brand);

        // try {
        //     DB::beginTransaction();
        //     $brand = Brand::create([
        //         'name' => $request->name,
        //         'slogan' => $request->slogan,
        //     ]);

        //     return response()->json([
        //         'status' => 'success',
        //         'brand' => $brand,
        //     ]);

        //     DB::commit();
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     DB::rollBack();
        //     Log::error($th);

        //     return response()->json([
        //         'status' => 'error',
        //     ], 500);
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(updateBrandRequest $request, Brand $brand)
    {
        $newData = [];

        if (isset($request->name)) {
            $newData['name'] = $request->name;
        }

        if (isset($request->slogan)) {
            $newData['slogan'] = $request->slogan;
        }

        $brand->update($newData);

        return response()->json([
            'status' => 'success',
            'brand' => $brand,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json([
            'status' => 'deleted success',
        ]);
    }
}
