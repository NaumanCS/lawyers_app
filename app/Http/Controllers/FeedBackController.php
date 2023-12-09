<?php

namespace App\Http\Controllers;

use App\Models\CreateMeeting;
use App\Models\feedBack;
use App\Models\Order;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class FeedBackController extends Controller
{
    private function updateOrderStatusAndTimeSpan($orderId, $selectTimeSpan)
    {
        $orderStatus = Order::where('id', $orderId->order_id)->first();

        if ($orderStatus) {
            $orderStatus->update([
                'status' => 'completed',
            ]);
        }

        $meetingController = new JitsiVideoCallController();
        $meetingController->book_time_span($selectTimeSpan, null);
    }

    public function feedback_store(Request $request)
    {
        $obj = feedBack::create([
            'lawyer_id' => $request->lawyer_id,
            'customer_id' => $request->customer_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        $orderId = CreateMeeting::where('meeting_link', $request->meeting_link)->first();
        $selectTimeSpan = $orderId->select_time_span;

        $this->updateOrderStatusAndTimeSpan($orderId, $selectTimeSpan);

        $meetingSchedule = CreateMeeting::where('meeting_link', $request->meeting_link)->delete();

        Toastr::success('FeedBack Submitted.');
        return redirect()->route('meeting.schedule.list');
    }

    public function deleteMeeting($meetingId)
    {
        $orderId = CreateMeeting::where('meeting_link', $meetingId)->first();
        $selectTimeSpan = $orderId->select_time_span;

        $this->updateOrderStatusAndTimeSpan($orderId, $selectTimeSpan);

        $meetingSchedule = CreateMeeting::where('meeting_link', $meetingId)->delete();

        return response()->json(['message' => 'Meeting record deleted successfully']);
    }
}
