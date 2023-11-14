<?php

namespace App\Http\Controllers\Lawyer;

use App\Http\Controllers\Controller;
use App\Models\AccountDetail;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class LawyerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user = Auth::user();
        // if ($user->is_document_submit == 1) {
        if ($user->document_status == 'approved') {
            $service = Service::where('user_id', Auth::id())->count();
            $booking = Service::where('user_id', Auth::id())->count();
            $category = Service::where('user_id', Auth::id())->count();

            return view('front-layouts.pages.lawyer.dashboard', get_defined_vars());
        } else {
            return redirect()->route('lawyer.document.verification');
        }
    }
    public function document_submission()
    {
        $user = Auth::user();
        if ($user->document_status == 'approved') {

            return redirect()->route('lawyer.dashboard');
        } else {
            return view('front-layouts.pages.lawyer.document-verification',get_defined_vars());
        }
       
    }

    public function submit_documents(Request $request)
    {
        $auth_user = Auth::user();
        $user = User::where('id', $auth_user->id)->first();
        if ($request->hasFile('degree')) {
            $imageName = uniqid() . '_' . time() . '_' . $request->file("degree")->getClientOriginalName();
            $image = $request->file('degree');
            $image->move(public_path('uploads/lawyer/documents'), $imageName);
            $user->degree = $imageName;
        }
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $uploadedImages = [];

            foreach ($images as $image) {
                // Generate a unique name for the image
                $imageName = uniqid() . '_' . time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads/lawyer/documents'), $imageName);
                $uploadedImages[] = 'uploads/lawyer/documents/' . $imageName;
            }
            $user->certificates = $uploadedImages;
            $user->is_document_submit = 1;
            $user->document_status = "pending";
            $user->update();
            return redirect()->route('lawyer.dashboard')->with(['message' => 'Documents uploaded successfully', 'images' => $uploadedImages]);
        }
    }
    public function document_submission_update()
    {
        $user = Auth::user();
        return view('front-layouts.pages.lawyer.document-verification-update',get_defined_vars());
    }

    public function documents_update(Request $request)
    {
        
        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        if ($request->file('qualification_certificate')) {
            $qualification = rand(0, 9999) . time() . '.' . $request->qualification_certificate->extension();
            $request->file('qualification_certificate')->move(public_path('uploads/lawyer/documents'), $qualification);
            $user->qualification_certificate = $qualification;
        }
        if ($request->file('high_court_licence')) {
            $high_court_licence = rand(0, 9999) . time() . '.' . $request->high_court_licence->extension();
            $request->file('high_court_licence')->move(public_path('uploads/lawyer/documents'), $high_court_licence);
            $user->high_court_licence = $high_court_licence;
        }
        if ($request->file('supreme_court_licence')) {
            $supreme_court_licence = rand(0, 9999) . time() . '.' . $request->supreme_court_licence->extension();
            $request->file('supreme_court_licence')->move(public_path('uploads/lawyer/documents'), $supreme_court_licence);
            $user->supreme_court_licence = $supreme_court_licence;
        }
        $user->update();

        Flash::success('Your Data is updated successfully');
        return redirect()->route('lawyer.document.verification')->with('message', 'Your Data is updated successfully');
    }

    public function profile_setting()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('front-layouts.pages.lawyer.profile', compact('user'));
    }

    public function profile_submit(Request $request)
    {
        $request->validate([
            'name' => "required|string|min:3",
            'email' => "required|email|unique:users,email," . Auth::user()->id,
            'phone' => "required|regex:/^[0-9]{10,}$/",
            'date_of_birth' => "required|date",
            'gender' => "required",
            'address' => "required|string",
            'country' => "required|string",
            'city' => "required|string",
            'state' => "required|string",
            'postal_code' => "required|regex:/^[0-9]+$/",
        ]);

        $id = Auth::user()->id;
        $user = User::where('id', $id)->first();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender = $request->input('gender');
        $user->address = $request->input('address');
        $user->country = $request->input('country');
        $user->city = $request->input('city');
        $user->state = $request->input('state');
        $user->postal_code = $request->input('postal_code');

        if ($request->file()) {
            $imageName = rand(0, 9999) . time() . '.' . $request->image->extension();
            $request->file('image')->move(public_path('uploads/user'), $imageName);
            $user->image = $imageName;
        }
        $user->update();

        Flash::success('Your Data is updated successfully');
        return redirect()->back()->with('message', 'Your Data is updated successfully');
    }

    public function lawyer_account_update(Request $request){
        
        $lawyerAccount=AccountDetail::where('user_id',$request->lawyer_id)->first();
        if($lawyerAccount){
            $lawyerAccount->update($request->except( '_token','bank_account','jazzcash_account'));
            if($request->bank_account != null){
                $lawyerAccount->bank_account='1';

            }
            if($request->jazzcash_account != null){
                $lawyerAccount->jazzcash_account='1';

            }
          

        }else{
            $lawyerAccount = AccountDetail::create($request->except( '_token','user_id','user_type'));
            $lawyerAccount->user_id=$request->lawyer_id;
            $lawyerAccount->user_type='lawyer';
            $lawyerAccount->save();
        }

        Flash::success('Your Account Detail is updated successfully');
        return redirect()->route('lawyer.profile.setting')->with('message', 'Your Data is updated successfully');
    }
}
