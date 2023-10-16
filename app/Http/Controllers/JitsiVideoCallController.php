<?php

namespace App\Http\Controllers;

use App\Models\CreateMeeting;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Yoeunes\Toastr\Facades\Toastr;

class JitsiVideoCallController extends Controller
{
    public function jitsi_video_call($id)
    {
        $meetingLink = $id;
        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingLink)->with('spanTime')->first();

        // Get the current time
        $currentTime = now(); // You may need to adjust this based on your timezone

        // Split the time_spans into start and end times
        [$startTime, $endTime] = explode(' - ', $meetingSchedule->spanTime->time_spans);

        $startTime = \Carbon\Carbon::parse($startTime); // Convert the start time to a Carbon instance
        $endTime = \Carbon\Carbon::parse($endTime);
        // dd($endTime);

        // Check if the current time is equal to or after the start time
        if ($currentTime >= $startTime) {
            if ($currentTime <= $endTime) {
                return view('jitsiVideoCall.startNew', get_defined_vars());
            } else {
                Toastr::error('The meeting time has been ended.', 'Create New Meeting');
                return redirect()->back();
            }
        } else {
            // Show a toastr notification that the meeting time has not started
            Toastr::error('The meeting time has not started yet.', 'Meeting Not Started');
            return redirect()->back();
        }
    }

    public function video_call($id)
    {
        $meetingLink = $id;
        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingLink)->with('spanTime')->first();

        // Get the current time
        $currentTime = now(); // You may need to adjust this based on your timezone

        // Split the time_spans into start and end times
        [$startTime, $endTime] = explode(' - ', $meetingSchedule->spanTime->time_spans);

        $startTime = \Carbon\Carbon::parse($startTime); // Convert the start time to a Carbon instance
        $endTime = \Carbon\Carbon::parse($endTime);
        // dd($endTime);

        // Check if the current time is equal to or after the start time
        if ($currentTime >= $startTime) {
            if ($currentTime <= $endTime) {
                return view('jitsiVideoCall.startNew', get_defined_vars());
            } else {
                Toastr::error('The meeting time has been ended.', 'Create New Meeting');
                return redirect()->back();
            }
        } else {
            // Show a toastr notification that the meeting time has not started
            Toastr::error('The meeting time has not started yet.', 'Meeting Not Started');
            return redirect()->back();
        }
    }


    public function video_call_lawyer($id)
    {
        $meetingLink = $id;
        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingLink)->with('spanTime')->first();

        // Get the current time
        $currentTime = now(); // You may need to adjust this based on your timezone

        // Split the time_spans into start and end times
        [$startTime, $endTime] = explode(' - ', $meetingSchedule->spanTime->time_spans);

        $startTime = \Carbon\Carbon::parse($startTime); // Convert the start time to a Carbon instance
        $endTime = \Carbon\Carbon::parse($endTime);
        // dd($endTime);


        if ($currentTime >= $startTime) {
            if ($currentTime <= $endTime) {
                return view('jitsiVideoCall.startLawyerVideo', get_defined_vars());
            } else {
                Toastr::error('The meeting time has been ended.', 'Create New Meeting');
                return redirect()->back();
            }
        } else {

            Toastr::error('The meeting time has not started yet.', 'Meeting Not Started');
            return redirect()->back();
        }
    }

    public function storeMeetingLink(Request $request)
    {
        $meetingLink = $request->input('meeting_link');

        // Validation can be added here if needed

        // Store the meeting link in the database using the CreateMeeting model
        $auth = auth()->user();
        $meeting = new CreateMeeting();
        $meeting->created_by = $auth->id;
        $meeting->meeting_with = $request->lawyer_id;

        $meeting->save();

        return response()->json(['message' => 'Meeting link sent successfully']);
    }

    // In Lawyers Side
    public function lawyer_meeting_list()
    {
        $data = CreateMeeting::where('meeting_with', Auth::id())->get();
        return view('front-layouts.pages.lawyer.meeting.list', get_defined_vars());
    }

    // meeting schedule 
    public function meeting_schedule_list()
    {
        $obj = CreateMeeting::where('created_by', auth()->user()->id)->with('spanTime', 'user')->get();

        return view('front-layouts.pages.customer.meetingSchedule.list', get_defined_vars());
    }
    public function meeting_schedule_create($id)
    {
        $auth = auth()->user();
        $lawyerDetail = User::where('id', $id)->with('time_spans')->first();
        $checkPaymentSlip = Order::where('customer_id', $auth->id)->where('lawyer_id', $lawyerDetail->id)->first();

        if ($checkPaymentSlip) {
            return view('front-layouts.pages.customer.meetingSchedule.create', get_defined_vars());
        } else {
            return redirect()->back()->with('error', 'Please Book a service Or Upload the payment Slip');
        }
       
    }

    public function meeting_schedule_store(Request $request)
    {

        // dd($request); 
        $roomName = Str::random(10); // You can adjust the length as needed
        // $baseURL = 'https://lawyers-app/meeting/';
        // $meetingLink = $baseURL . $roomName;
        $meetingLink = $roomName;



        $auth = auth()->user();
        $meeting = new CreateMeeting();
        $meeting->created_by = $auth->id;
        $meeting->meeting_with = $request->lawyer_id;
        $meeting->meeting_link = $meetingLink;
        $meeting->select_time_span = $request->select_time_span;
        $meeting->save();

        return redirect()->route('lawyer.list');
    }
}
