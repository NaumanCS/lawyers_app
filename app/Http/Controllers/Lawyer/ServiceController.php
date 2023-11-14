<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\LawyersTimeSpan;
use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $data = Service::where('user_id', Auth::id())->with('category')->get();
        return view('front-layouts.pages.lawyer.service.list', get_defined_vars());
    }

    public function create($id)
    {
        $service = null; // Initialize $service as null
        if ($id) {
           
            $service = Service::where('id', $id)->first();
        }else{
            $id = 0;
           
        }
       
        $categories = Category::get();
        return view('front-layouts.pages.lawyer.service.create', get_defined_vars());
    }

    public function update(Request $request)
    {
        $service = Service::where('id', $request->id)->first();
        $id = $request->id;
        $categories = Category::get();
        return view('front-layouts.pages.lawyer.service.create', get_defined_vars());
    }

    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string',
        //     'location' => 'required|string',
        //     'amount' => 'required|numeric',
        //     'categories_id' => 'required',
        //     'start_day' => 'required',
        //     'end_day' => 'required',
        //     'start_time' => 'required',
        //     'end_time' => 'required',
        //     'add_extra_day' => 'required',
        //     'cover_image' => 'required',
        // ]);
     
        $update_id = $request->id;
        $selectedDays = $request->input('days', []);
        if ($update_id) {
            $service = Service::where('id', $request->id)->first();
            $service->title = $request->title;
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $request->categories_id;
            $service->days = $selectedDays;
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->add_extra_day = $request->add_extra_day;
            $service->extra_day = $request->extra_day;
            $service->extra_day_start_time = $request->extra_day_start_time;
            $service->extra_day_end_time = $request->extra_day_end_time;
            $service->user_id = Auth::id();

            if ($request->file('cover_image')) {
                $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                $request->file('cover_image')->move(public_path('uploads/lawyer/service'), $imageName);
                $service->image = $imageName;
            }
            $service->update();

            $this->make_time_slots(Auth::id(), $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

            return redirect()->route('lawyer.service.list')->with('message', 'Service Updated Successfully');
        } else {
            $service = new Service;

            $service->title = $request->title;
            $service->location = $request->location;
            $service->amount = $request->amount;
            $service->categories_id = $request->categories_id;
            $service->start_day = $request->start_day;
            $service->end_day = $request->end_day;
            $service->start_time = $request->start_time;
            $service->end_time = $request->end_time;
            $service->add_extra_day = $request->add_extra_day;
            $service->extra_day = $request->extra_day;
            $service->extra_day_start_time = $request->extra_day_start_time;
            $service->extra_day_end_time = $request->extra_day_end_time;
            $service->user_id = Auth::id();

            if ($request->file('cover_image')) {
                $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
                $request->file('image')->move(public_path('uploads/lawyer/service'), $imageName);
                $service->cover_image = $imageName;
            }
            $service->save();

            $this->make_time_slots(Auth::id(), $service->id, $request->start_time, $request->end_time, $request->extra_day_start_time ?? null, $request->extra_day_end_time ?? null);

            return redirect()->route('lawyer.service.list')->with('message', 'Service Added Successfully');
        }
    }

    public function make_time_slots($user_id, $service_id, $req_start_time, $req_end_time, $req_extra_day_start_time, $req_extra_day_end_time)
    {
        $time_spans = LawyersTimeSpan::where('user_id', $user_id)->where('service_id', $service_id)->delete();
        $start_time = Carbon::createFromFormat('H:i', $req_start_time);
        $end_time = Carbon::createFromFormat('H:i', $req_end_time);
        $slot_duration = 15;
        $timeSlots = [];
        $extraDayTimeSlots = [];

        while ($start_time <= $end_time) {
            $slot_start = $start_time->format('H:i');
            $start_time->addMinutes($slot_duration);
            $slot_end = $start_time->format('H:i');

            $timeSlots[] = $slot_start . ' - ' . $slot_end;
        }
        if ($req_extra_day_start_time && $req_extra_day_end_time) {
            $extra_day_start_time = Carbon::createFromFormat('H:i', $req_extra_day_start_time);
            $extra_day_end_time = Carbon::createFromFormat('H:i', $req_extra_day_end_time);

            while ($extra_day_start_time <= $extra_day_end_time) {
                $extra_slot_start = $extra_day_start_time->format('H:i');
                $extra_day_start_time->addMinutes($slot_duration);
                $extra_slot_end = $extra_day_start_time->format('H:i');

                $timeSlots[] = $extra_slot_start . ' - ' . $extra_slot_end;
            }
        }
        // dd($timeSlots);

        $slotsData = [];
        foreach ($timeSlots as $key => $timeSlot) {
            $slotsData[] = [
                'user_id' => $user_id,
                'service_id' => $service_id,
                'time_spans' => $timeSlot,
                'extra_day_time_spans' => $extraDayTimeSlots[$key] ?? null,
            ];
        }
        DB::table('lawyers_time_spans')->insert($slotsData);

        return $slotsData;
    }

    public function detail()
    {
        //
    }

    public function delete(Request $request)
    {
        //
    }

    public function category_list()
    {
        //
    }
}
