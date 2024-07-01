<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Brian2694\Toastr\Facades\Toastr;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obj = Location::get();
        return view('layouts.pages.locations.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'New Locations';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = Location::whereId($id)->first();
        }

        return view('layouts.pages.locations.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if (isset($id) && !empty($id)) {
            Location::whereId($id)->update($request->all());
        } else {
            //Create
            $obj = Location::create($request->all());
        }
        return redirect(route('admin.locations.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Location $location, $id)
    {
        $title = 'Locations Detail';
        $locations = Location::where('id', $id)->first();
        return view('layouts.pages.locations.detail', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Location $location)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        $delete = Location::destroy($id);


        if ($delete == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Location deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Location not found.',
            ]);
        }
    }
}
