<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\Service;
use App\Models\Support;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        $services = Service::get();
        $cities = User::where('role', 'lawyer')->get();

        return view('front-layouts.pages.home', get_defined_vars());
    }

    public function categories()
    {
        $categories = Category::paginate(9);
        return view('front-layouts.pages.categories', get_defined_vars());
    }

    public function search(Request $request)
    {
        $categories = Service::where('categories_id', $request->select_category)->orWhere('location', $request->select_location)->get();
    }

    public function lawyers_with_category($id)
    {
        $lawyerDetail = User::where('id', $id)->with('time_spans')->first();
        return view('front-layouts.pages.lawyers', get_defined_vars());
    }

    public function lawyers_services(Request $request, $filter)
    {
        if ($filter) {
            $services = Service::where('categories_id', $filter)->with('user', 'category')->paginate(9);
        } else {
            $services = Service::where('categories_id', $request->category_id)->orWhere('location', $request->location)->orderBy('amount', $request->price_order)->paginate(9);
        }
        $categories = Category::get();
        return view('front-layouts.pages.online_lawyers', get_defined_vars());
    }

    public function advanceSearch(Request $request)
    {
        $categories = Category::get();
        return view('front-layouts.pages.online_lawyers', get_defined_vars());
    }
    public function contact_us()
    {
        return view('front-layouts.pages.contactUs');
    }

    public function support_msg(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|regex:/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            Support::create([
                'user_name' => $request->name,
                'user_email' => $request->email,
                'message' => $request->message,
            ]);
            Session::flash('message', 'Your Message has been forwarded to the Support Successfully. We will contact you soon.');
            return redirect()->back();
        }
    }
}
