<?php

namespace App\Http\Controllers;

use App\Models\CreateMeeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JitsiVideoCallController extends Controller
{
    public function jitsi_video_call($id)
    {
        $lawyerId = $id;
        return view('jitsiVideoCall.startNew', get_defined_vars());
    }

    public function video_call_lawyer()
    {
       
        return view('jitsiVideoCall.startLawyerVideo', get_defined_vars());
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
        $meeting->meeting_link = $meetingLink;
        $meeting->save();

        return response()->json(['message' => 'Meeting link sent successfully']);
    }

    // In Lawyers Side
    public function lawyer_meeting_list()
    {
        $data = CreateMeeting::where('meeting_with', Auth::id())->get();
        return view('front-layouts.pages.lawyer.meeting.list', get_defined_vars());
    }
}