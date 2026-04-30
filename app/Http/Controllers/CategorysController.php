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

        //$categorys1 = Categorys::get();
        /*return Inertia::render('viewsdata/Categories', [
            'categorys' => $categorys1
        ]);*/
        return Inertia::render('Dashboard', [
            'activeremount' => true
        ]);
        usleep(300000); //0.3 sec
        //return redirect()->route('dashboard');
        //return to_route('dashboard', [], 303);
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

    public function getArrayFormData(String $str):array
    {
        $symbols = array("\r", "\t"); 
        $clean1 = str_replace($symbols, "", $str); 
        $symbols = array("\n");
        $clean = str_replace($symbols, ":", $clean1); 
        $arr1 = explode("; ", $clean);

        foreach ($arr1 as &$value) {
            $pos1 = strpos($value, ":-");
            if ($pos1 !== false) {
                $value = substr($value, 0, $pos1);
            }
        }

        $resarr = [];
        $len = count($arr1);

        for ($i=0; $i<$len; $i++) {
            $pos1c = strpos($arr1[$i], "\"");
            $pos2c = strpos($arr1[$i], "\"", $pos1c + 1);   
            $name = "";   $val = "";
            if ($pos1c !== false) {
                $pos1c = $pos1c + 1;
                if ($pos2c !== false) {
                    $name = substr($arr1[$i], $pos1c, ($pos2c - $pos1c));
                    $val = substr($arr1[$i], $pos2c+3);
                    $resarr[$name] = $val;
                }
            }
        }

        return $resarr;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Int $id)
    {
        $input1 = file_get_contents('php://input');
        $arr1 = $this->getArrayFormData($input1);
        //$arr2 = ['catname' => $arr1['catname'], 'catdescription' => $arr1['catdescription']];

        $categorys1 = Categorys::updateOrCreate(['cat_id' => $id], ['catname' => $arr1['catname'], 'catdescription' => $arr1['catdescription']]);
        //$categorys1 = Categorys::findOrFail($categorys->cat_id);
        //$categorys1->catname = $request->input('catname');
        //$categorys1->catdescription = $request->input('catdescription');
        //$categorys1->save();
        
        //$categorys1 = Categorys::get();
        //return $categorys1;
        //return Inertia::render('Dashboard');
        //return to_route('dashboard', [], 303);
        
        return Inertia::render('Dashboard', [
            'activeremount' => true
        ]);
    }

    public function update_api(Request $request, $id)
    {
        $input1 = file_get_contents('php://input');
        $arr1 = $this->getArrayFormData($input1);

        $categorys1 = Categorys::findOrFail($id);
        $categorys1->name = $arr1['catname'];
        $categorys1->description = $arr1['catdescription'];
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

        //return Inertia::render('Dashboard');
        return Inertia::render('Dashboard', [
            'activeremount' => true
        ]);
    }

    public function destroy_api($id)
    {
        $categorys1 = Categorys::findOrFail($id);
        $categorys1->delete();

        $categorys1 = Categorys::get();
        return $categorys1;
    }
}
