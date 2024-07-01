<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = Setting::get();
        return view('layouts.pages.setting.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $title = 'New Locations';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Setting::whereId($id)->first();
           
        }

        return view('layouts.pages.setting.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if (isset($id) && !empty($id)) {
            Setting::whereId($id)->update($request->all());
        } else {
            //Create
            $obj = Setting::create($request->all());
        }
        return redirect(route('admin.setting.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Setting $setting, $id)
    {
        $title = 'Locations Detail';
        $locations = Setting::where('id', $id)->first();
        return view('layouts.pages.setting.detail', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        $delete = Setting::destroy($id);


        if ($delete == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Setting deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Setting not found.',
            ]);
        }
    }
}
