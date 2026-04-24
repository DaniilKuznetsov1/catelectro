<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products1 = Products::paginate(10);
        return $products1;
    }

    public function filterIndex(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $products1 = Products::where('cat_id', '=', $cat_id)->paginate(10);
        return $products1;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product1 = new Products();
        $product1->name = $request->input('name');
        $product1->description = $request->input('description');
        $product1->photo = $request->input('photo');
        $product1->price = $request->input('price');
        $product1->valprice = $request->input('valprice');
        $product1->category_id = $request->input('category_id');
        $product1->save();

        $products1 = Products::paginate(10);
        return $products1;
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //$products1 = Products::findOrFail($id);
        return $products;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        return $products;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        $product1 = $products;

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        //
    }
}
