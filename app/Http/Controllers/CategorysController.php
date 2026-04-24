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
    public function index_api()
    {
        $categorys1 = Categorys::get();
        return $categorys1;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('viewsdata/CreateCategory');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store_api(Request $request)
    {
        $categorys1 = new Categorys();
        $categorys1->name = $request->input('catname');
        $categorys1->description = $request->input('catdescription');
        $categorys1->save();

        $categorys1 = Categorys::get();
        return $categorys1;
    }

    public function store(Request $request)
    {
        /*$categorys1 = new Categorys();
        $categorys1->name = $request->input('catname');
        $categorys1->description = $request->input('catdescription');

        $categorys1->save();

        $categorys1 = Categorys;
        return $categorys1;*/

        Categorys::create($request->validate([
            'catname' => ['required', 'max:255'],
            'catdescription' => [],
        ]));

        $categorys1 = Categorys::get();
        return Inertia::render('viewsdata/Categories', [
            'categorys' => $categorys1
        ]);
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
    public function edit_api($id)
    {
        $categorys1 = Categorys::findOrFail($id);
        return $categorys1;
    }

    public function edit(Categorys $categorys)
    {
        $categorys1 = Categorys::findOrFail($categorys->cat_id);
        return Inertia::render('viewsdata/EditCategory', [
            'categorys' => $categorys1
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorys $categorys)
    {
        $categorys1 = Categorys::findOrFail($categorys->cat_id);
        $categorys1->name = $request->input('catname');
        $categorys1->description = $request->input('catdescription');
        $categorys1->save();

        $categorys1 = Categorys::get();
        return $categorys1;
    }

    public function update_api(Request $request, $id)
    {
        $categorys1 = Categorys::findOrFail($id);
        $categorys1->name = $request->input('catname');
        $categorys1->description = $request->input('catdescription');
        $categorys1->save();

        $categorys1 = Categorys::get();
        return $categorys1;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorys $categorys)
    {
        $categorys1 = Categorys::findOrFail($categorys->cat_id);
        $categorys1->delete();

        $categorys1 = Categorys::get();
        return $categorys1;
    }

    public function destroy_api($id)
    {
        $categorys1 = Categorys::findOrFail($id);
        $categorys1->delete();

        $categorys1 = Categorys::get();
        return $categorys1;
    }
}
