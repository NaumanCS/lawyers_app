<?php

namespace App\Http\Controllers;

use App\Models\CreateMeeting;
use App\Models\feedBack;
use App\Models\Order;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class FeedBackController extends Controller
{
    public function feedback_store(Request $request)
    {

        $obj = feedBack::create([
            'lawyer_id' => $request->lawyer_id,
            'customer_id' => $request->customer_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);
        $orderId = CreateMeeting::where('meeting_link', $request->meeting_link)->first();
        $orderStatus = Order::where('id', $orderId->order_id)->first();
        $orderStatus->update([
            'status' => 'completed',
        ]);

        $meetingSchedule = CreateMeeting::where('meeting_link', $request->meeting_link)->delete();

        Toastr::success('FeedBack Submited.');
        return redirect()->route('meeting.schedule.list');
    }

    public function deleteMeeting($meetingId)
    {
        // Find and delete the meeting record
        $orderId = CreateMeeting::where('meeting_link', $meetingId)->first();
        $orderStatus = Order::where('id', $orderId->order_id)->first();
        $orderStatus->update([
            'status' => 'completed',
        ]);

        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingId)->delete();

        return response()->json(['message' => 'Meeting record deleted successfully']);
    }
}
