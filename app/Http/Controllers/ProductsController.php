<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Categorys;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Inertia\Inertia;
use Inertia\Response;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_api()
    {
        $products1 = Products::select('id','name','description','price','valprice','category_id')->get();//paginate(10);
        //echo(var_dump($products1));
        return $products1;
    }

    public function filterIndex_api(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $products1 = Products::where('cat_id', '=', $cat_id)->select('id','name','description','price','valprice','category_id')->get();//->paginate(10);
        return $products1->all();
    }

    public function index()
    {
        $products1 = Products::paginate(10);
        return Inertia::render('viewsdata/Products', [
            'products' => $products1
        ]);
    }

    public function filterIndex(Request $request)
    {
        $cat_id = $request->input('cat_id');
        $products1 = Products::where('cat_id', '=', $cat_id)->paginate(10);
        return Inertia::render('viewsdata/Products', [
            'products' => $products1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('viewsdata/CreateProduct');
    }

    public function testReqCreate(Request $request) 
    {
        $ret = 0;

        if (mb_strlen($request->input('name')) > 0) {
            $ret = $ret + 1;
        }
        if (mb_strlen($request->input('price')) > 0) {
            $ret = $ret + 1;
        }
        $categorys1 = Categorys::find($request->input('category_id'))->get();
        if (is_null($categorys1) == false) {
            $ret = $ret + 1;
        }

        return $ret;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_api(Request $request)
    {
        $ret = $this->testReqCreate($request);
        if ($ret == 3) {
            $product1 = new Products();
            $product1->name = $request->input('name');
            $product1->description = $request->input('description');
            $product1->photo = $request->file('photo');
            //$product1->photo = $request->input('photo');
            $product1->price = $request->input('price');
            $product1->valprice = $request->input('valprice');
            $product1->category_id = $request->input('category_id');
            $product1->save();
        }

        $products1 = Products::get();
        return $products1->all();
    }

    public function store(Request $request)
    {
        /*$product1 = new Products();
        $product1->name = $request->input('name');
        $product1->description = $request->input('description');
        $product1->photo = $request->file('photo');
        $product1->price = $request->input('price');
        $product1->valprice = $request->input('valprice');
        $product1->category_id = $request->input('category_id');
        $product1->save();

        $products1 = Products::paginate(10);
        return $products1;*/

        Products::create($request->validate([
            'name' => ['required', 'max:255'],
            'description' => [],
            'photo' => [],
            'price' => ['required', 'max:50'],
            'valprice' => ['required', 'max:3'],
            'category_id' => [],
        ]));

        $products1 = Products::paginate(10);
        /* return Inertia::render('viewsdata/Products', [
            'products' => $products1
        ]); */
        return Inertia::render('Dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Products $products)
    {
        //return Inertia::render('viewsdata/CreateProduct');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Products $products)
    {
        $product1 = Products::findOrFail($products->id);
        return Inertia::render('viewsdata/EditProduct', [
            'products' => $product1
        ]);
    }

    public function edit_api($id)
    {
        $product1 = Products::findOrFail($id);
        return $product1;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Products $products)
    {
        $ret = $this->testReqCreate($request);
        if ($ret == 3) {
            $product1 = Products::findOrFail($products->id);
            $product1->name = $request->input('name');
            $product1->description = $request->input('description');
            $product1->photo = $request->input('photo');
            $product1->price = $request->input('price');
            $product1->valprice = $request->input('valprice');
            $product1->category_id = $request->input('category_id');
            $product1->save();
        }

        //$products1 = Products::paginate(10);
        return Inertia::render('Dashboard');
    }

    public function update_api(Request $request, $id)
    {
        $ret = $this->testReqCreate($request);
        if ($ret == 3) {
            $product1 = Products::findOrFail($id);
            $product1->name = $request->input('name');
            $product1->description = $request->input('description');
            $product1->photo = $request->input('photo');
            $product1->price = $request->input('price');
            $product1->valprice = $request->input('valprice');
            $product1->category_id = $request->input('category_id');
            $product1->save();
        }
        $products1 = Products::get();
        return $products1->all();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Products $products)
    {
        $product1 = Products::findOrFail($products->id);
        $product1->delete();

        return Inertia::render('Dashboard');
    }

    public function destroy_api($id)
    {
        $product1 = Products::findOrFail($id);
        $product1->delete();

        $products1 = Products::get();
        return $products1->all();
    }
}
