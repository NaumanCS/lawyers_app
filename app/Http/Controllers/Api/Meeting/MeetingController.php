<?php

namespace App\Http\Controllers\Api\Meeting;

use App\Http\Controllers\Controller;
use App\Models\CreateMeeting;
use App\Models\LawyersTimeSpan;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CreateMeetingNotification;
use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;
use Illuminate\Support\Str;

class MeetingController extends Controller
{
    public function meeting_schedule_store($lawyerId, $date, $selectTimeSpan, $orderId)
    {


        $roomName = str::random(10); 
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


        // Notification Here

        $newMeeting = $meeting->id;
        $newMeeting = CreateMeeting::find($newMeeting);
        $customerName = User::where('id',$newMeeting->created_by)->first();
        $lawyer = User::find($newMeeting->meeting_with); // Replace $userId with the actual user ID
        $lawyer->notify(new CreateMeetingNotification($newMeeting,$customerName));

    }

    public function book_time_span($timeSpan,$booked)
    {
        $checkTimeSpan = LawyersTimeSpan::find($timeSpan);

        if ($checkTimeSpan) {
            $checkTimeSpan->update([
                'booked' => $booked,
            ]);
        } else {
            // Toastr::error('Lawyer Time Span Not Found');
            return response()->json(['error' => 'Lawyer Time Span Not Found'], 500);
        }
    }

    public function meeting_status(Request $request){

        $meeting=CreateMeeting::where('id',$request->meeting_id)->first();
        if($meeting){
            $user=User::where('id',$request->user_id)->first();
            if($user->role == 'user'){
                $meeting->update([
                    'user_join' => "joined",
                ]);
            }else{
                $meeting->update([
                    'lawyer_join' => "joined",
                ]); 
            }

            $checkJoined=CreateMeeting::where('id',$request->meeting_id)->first();
            $order=Order::where('id',$checkJoined->order_id)->first();
            if($order && $checkJoined->lawyer_join == "joined" && $checkJoined->user_join == "joined"){
                $order->update(['status' => 'completed',
            ]);
            }else{
    
                return response()->json(['message' => 'Leaved Successefully'], 200);    
            }
          
            return response()->json(['message' => 'meeting status updated'], 200);
        }else{
            return response()->json(['error' => 'Failed to update meeting status'], 500);
        }
       
          
    }
}
