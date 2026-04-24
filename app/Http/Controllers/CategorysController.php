<?php

namespace App\Http\Controllers;

use App\Models\Categorys;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategorysController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorys1 = Categorys::paginate(10);
        return $categorys1;
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
        $categorys1 = new Categorys();
        $categorys1->name = $request->input('catname');
        $categorys1->description = $request->input('catdescription');

        $categorys1->save();

        $categorys1 = Categorys::paginate(10);
        return $categorys1;
    }

    /**
     * Display the specified resource.
     */
    public function show(Categorys $categorys)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorys $categorys)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorys $categorys)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorys $categorys)
    {
        //
    }
}
