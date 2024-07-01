<?php

namespace App\Http\Controllers;

use App\Models\CreateMeeting;
use App\Models\LawyersTimeSpan;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CreateMeetingNotification;
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
        $orderCheck = Order::where('id', $meetingSchedule->order_id)->first();
        $paymentSlip = $orderCheck->payment_slip;
        if ($meetingSchedule && $meetingSchedule->spanTime) {
            $currentTime = now();
            $createdTime = $meetingSchedule->created_at->addHours(2);
            $currentDate = $currentTime->toDateString();

            [$startTime, $endTime] = explode(' - ', $meetingSchedule->spanTime->time_spans);
            $startTime = \Carbon\Carbon::parse($startTime);
            $endTime = \Carbon\Carbon::parse($endTime);



            if ($orderCheck != null && $orderCheck->payment_slip != null && $orderCheck->payment_slip != 'http://127.0.0.1:8000/admin/assets/img/uploadslip.jpg') {

                if ($currentTime > $createdTime) {
                    if ($currentDate >= $meetingSchedule->date && $currentTime >= $startTime) {
                        if ($currentDate <= $meetingSchedule->date && $currentTime <= $endTime) {
                            $lawyerId = $meetingSchedule->meeting_with;
                            $customerId = auth()->user()->id;
                            // return view('jitsiVideoCall.startNew', get_defined_vars());
                            return view('jitsiVideoCall.zegoCloudMeeting', get_defined_vars());
                        } else {
                            Toastr::error('The meeting time has been ended.', 'Create New Meeting');
                            return redirect()->back();
                        }
                    } else {
                        // Show a toastr notification that the meeting time has not started
                        Toastr::error('The meeting time has not started yet.', 'Meeting Not Started');
                        return redirect()->back();
                    }
                } else {
                    Toastr::error('Meeting will start after 2 hours,after reviewing your payment.');
                    return redirect()->back();
                }
            } else {

                Toastr::error('Upload Payment slip');
                return redirect()->back();
            }
        } else {
            Toastr::error('There is no meeting record or selected time');
            return redirect()->back();
        }
    }


    public function video_call_lawyer($id)
    {

        $meetingLink = $id;
        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingLink)->with('spanTime')->first();

        if ($meetingSchedule && $meetingSchedule->spanTime) {
            $currentTime = now();
            $currentDate = $currentTime->toDateString();
            // dd($meetingSchedule);
            [$startTime, $endTime] = explode(' - ', $meetingSchedule->spanTime->time_spans);

            $startTime = \Carbon\Carbon::parse($startTime);
            $endTime = \Carbon\Carbon::parse($endTime);

            if ($currentDate >= $meetingSchedule->date && $currentTime >= $startTime) {
                if ($currentDate <= $meetingSchedule->date && $currentTime <= $endTime) {
                    // return view('jitsiVideoCall.startLawyerVideo', get_defined_vars());
                    return view('jitsiVideoCall.zegoMeetingLawyer', get_defined_vars());
                } else {
                    Toastr::error('The meeting time has been ended.', 'Create New Meeting');
                    return redirect()->back();
                }
            } else {
                Toastr::error('The meeting time has not started yet.', 'Meeting Not Started');
                return redirect()->back();
            }
        } else {
            Toastr::error('There is no meeting record.', 'Create New Meeting');
            return redirect()->route('lawyer_meeting_list');
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
        $data = CreateMeeting::where('meeting_with', Auth::id())->with('createdByUser')->get();

        return view('front-layouts.pages.lawyer.meeting.list', get_defined_vars());
    }

    // meeting schedule 
    public function meeting_schedule_list()
    {
        $approvedOrders = Order::where([
            'customer_id' => auth()->user()->id,
            'status' => 'approved'
        ])->pluck('id')->toArray();
    
        // Fetch meetings created by the authenticated user and related to approved orders
        $obj = CreateMeeting::where('created_by', auth()->user()->id)
            ->whereIn('order_id', $approvedOrders)
            ->with(['spanTime', 'user'])
            ->get();

        return view('front-layouts.pages.customer.meetingSchedule.list', get_defined_vars());
    }
    public function meeting_schedule_create($id)
    {
        $auth = auth()->user();
        $lawyerDetail = User::where('id', $id)->with('time_spans')->first();
        $checkPaymentSlip = Order::where('customer_id', $auth->id)->where('lawyer_id', $lawyerDetail->id)->first();

        if ($checkPaymentSlip && $checkPaymentSlip->status != 'completed') {
            return view('front-layouts.pages.customer.meetingSchedule.create', get_defined_vars());
        } else {
            return redirect()->back()->with('error', 'Please Book a service Or Upload the payment Slip');
        }
    }

    public function meeting_schedule_store($lawyerId, $date, $selectTimeSpan, $orderId)
    {


        $roomName = Str::random(10); // You can adjust the length as needed
        // $baseURL = 'https://lawyers-app/meeting/';
        // $meetingLink = $baseURL . $roomName;
        $meetingLink = $roomName;

        $auth = auth()->user();
        $meeting = new CreateMeeting();
        $meeting->order_id = $orderId;
        $meeting->created_by = $auth->id;
        $meeting->meeting_with = $lawyerId;
        $meeting->meeting_link = $meetingLink;
        $meeting->date = $date;
        $meeting->select_time_span = $selectTimeSpan;
        $meeting->save();


        $newMeeting = $meeting->id;
        $newMeeting = CreateMeeting::find($newMeeting);
        $getDate  = LawyersTimeSpan::where('id', $newMeeting->select_time_span)->first();
        $lawyer = User::find($newMeeting->meeting_with); // Replace $userId with the actual user ID
        $lawyer->notify(new CreateMeetingNotification($newMeeting, $getDate));

        return redirect()->route('lawyer.list');
    }

    public function book_time_span($timeSpan, $booked)
    {
        $checkTimeSpan = LawyersTimeSpan::find($timeSpan);

        if ($checkTimeSpan) {
            $checkTimeSpan->update([
                'booked' => $booked,
            ]);
        } else {
            Toastr::error('Lawyer Time Span Not Found');
            return redirect()->back();
        }
    }
}
