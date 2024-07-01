<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HelpCenter;
use Illuminate\Http\Request;

class HelpCenterController extends Controller
{
    public function index()
    {
        $obj = HelpCenter::get();
        return view('layouts.pages.helpCenter.index', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $title = 'Help Center Create';
        $obj = array();
        if (isset($id) && !empty($id)) {
            $obj = HelpCenter::whereId($id)->first();
           
        }

        return view('layouts.pages.helpCenter.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        if (isset($id) && !empty($id)) {
     

            $input = $request->except('_token');

            HelpCenter::whereId($id)->update($input);
        } else {
            //Create
            $obj = HelpCenter::create($request->all());
        }
        return redirect(route('admin.help.center.index'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $title = 'Locations Detail';
        $locations = HelpCenter::where('id', $id)->first();
        return view('layouts.pages.helpCenter.detail', get_defined_vars());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
       
        $delete = HelpCenter::destroy($id);


        if ($delete == 1) {
            return response()->json([
                'success' => true,
                'message' => 'Complaint deleted successfully.',
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Complaint not found.',
            ]);
        }
    }
}
