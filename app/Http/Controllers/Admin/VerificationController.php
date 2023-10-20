<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Notifications\BlockUser;
use App\Notifications\DocumentsApproved;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class VerificationController extends Controller
{
    public function all_verifications(){
        // $obj = User::where('role', 'lawyer')->where('is_document_submit', 1)->where('document_status', 'pending')->get();
        // $obj = User::where('role', 'lawyer')->where('document_status','!=', 'approved')->get();
        $obj = User::where('role', 'lawyer')->orWhere('document_status',null)->whereNotIn('document_status', ['approved'])->get();
       
        return view('layouts.pages.verifications.all_verifications', get_defined_vars());
    }
    public function details($id){
        $baseURL =url('/') . '/';
        $lawyer = User::find($id);
        $certificates = json_decode($lawyer->certificates);
        // dd($baseURL);
        return view('layouts.pages.verifications.document_detail', get_defined_vars());
    }

    public function document_approval(Request $request){
        $request->validate([
            'approval' => 'required|string'
        ]);

        $lawyer = User::where('id', $request->lawyer_id)->first();
        $lawyer->document_status = $request->approval;
        $lawyer->reason = $request->reason;
        $lawyer->update();

        return redirect()->route('admin.lawyer.verification')->with(['message' => 'Documents' . $request->approval . 'successfully']);
    }
    public function notify(){
        if (auth()->user()) {
            $user = User::first();
            Auth::user()->notify(new DocumentsApproved($user));
        }
    }

    public function blockUser(){
        $user = User::where('role', 'lawyer')->first();
        Notification::send($user, new BlockUser);
        // return view('layouts.pages.dashboard');
    }

    public function markAsRead($id){
        if($id){
            auth()->user()->notifications->where('id', $id)->markAsRead();
            // we can find this method in Models->user->notifiable->HasDatabaseNotifications;
        }
        return redirect()->back();
    }
}
