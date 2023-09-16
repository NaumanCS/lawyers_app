<?php

namespace App\Http\Controllers;

use App\Classes\AgoraDynamicKey\RtcTokenBuilder;
use App\Events\MakeAgoraCall;
use App\Http\Controllers\Controller;
use App\Models\CreateMeeting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AgoraVideoController extends Controller
{
    public function index(Request $request)
    {
        // fetch all users apart from the authenticated user
        $users = User::where('id', '<>', Auth::id())->get();
        return view('agora-chat', ['users' => $users]);
    }

    public function token(Request $request)
    {

        $appID = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');
        $channelName = $request->channelName;
        $user = Auth::user()->name;
        $role = RtcTokenBuilder::RoleAttendee;
        $expireTimeInSeconds = 3600;
        $currentTimestamp = now()->getTimestamp();
        $privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;

        $token = RtcTokenBuilder::buildTokenWithUserAccount($appID, $appCertificate, $channelName, $user, $role, $privilegeExpiredTs);

        return $token;
    }

    public function callUser(Request $request)
    {

        $data['userToCall'] = $request->user_to_call;
        $data['channelName'] = $request->channel_name;
        $data['from'] = Auth::id();

        broadcast(new MakeAgoraCall($data))->toOthers();
    }


    // 
    public function createMeeting($lawyerId)
    {
       $createdBy=auth()->user()->id;
       $meetWith=$lawyerId;
        return view('videoCall.createMeeting',get_defined_vars());
    }

    public function storeMeeting(Request $request)
{

    // Validate the form data (e.g., meeting_name, created_by, meet_with)

    $validatedData = $request->validate([
        'meeting_name' => 'required|string',
        'created_by' => 'required|string',
        'meeting_with' => 'required|string',
    ]);

    // Generate the meeting link (you can customize this logic)
    $meetingLink = 'https://lawyer-app/meetings/' . urlencode($validatedData['meeting_name']);

    // Insert the data into the meetings table
    CreateMeeting::create([
        'meeting_link' => $meetingLink,
        'created_by' => $validatedData['created_by'],
        'meeting_with' => $validatedData['meeting_with'],
    ]);

    // Redirect or return a response as needed
    return back(); // Redirect to the homepage or another page
}

    public function indexNew(Request $request)
    {
       
        // fetch all users apart from the authenticated user
        $users = User::where('id', '<>', Auth::id())->get();
        $checkMeeting=CreateMeeting::where('meeting_link',$request->meeting_link)->first();
      
        if ($checkMeeting) {
            return view('videoCallNew',get_defined_vars());
        }else{
            return back();
        }
       
    }


    // Metered Meeting
    public function createMeetingMetered(Request $request) {
        
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');
    

        // Contain the logic to create a new meeting
        $response = Http::post("https://{$METERED_DOMAIN}/api/v1/room?secretKey={$METERED_SECRET_KEY}", [
            'autoJoin' => true
        ]);

        $roomName = $response->json("roomName");
        
        return redirect("/meeting/{$roomName}"); // We will update this soon.
    }

    public function validateMeeting(Request $request) {
        $METERED_DOMAIN = env('METERED_DOMAIN');
        $METERED_SECRET_KEY = env('METERED_SECRET_KEY');

        $meetingId = $request->input('meetingId');

        // Contains logic to validate existing meeting
        $response = Http::get("https://{$METERED_DOMAIN}/api/v1/room/{$meetingId}?secretKey={$METERED_SECRET_KEY}");

        $roomName = $response->json("roomName");


        if ($response->status() === 200)  {
            return redirect("/meeting/{$roomName}"); // We will update this soon
        } else {
            return redirect("/?error=Invalid Meeting ID");
        }
    }
}
