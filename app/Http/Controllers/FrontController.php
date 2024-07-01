<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Chat;
use App\Models\HelpCenter;
use App\Models\Service;
use App\Models\Support;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index()
    {
       
        $categories = Category::take(6)->get();
        $services = Service::take(6)->get();
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
        // $categories = Service::where('categories_id', $request->select_category)->orWhere('location', $request->select_location)->get();

        $query = Service::with('user', 'category');
    
        if ($request->filled('select_category')) {
            $query->where('categories_id', $request->select_category);
        }
    
        if ($request->filled('select_location')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('city', $request->select_location);
            });
        }
    
        $services = $query->paginate(9);
        $categories = Category::get();

        return view('front-layouts.pages.online_lawyers', compact('services', 'categories'));
    }

    public function lawyers_with_category($id)
    {
        $lawyerDetail = User::where('id', $id)->with('time_spans')->first();
        return view('front-layouts.pages.lawyers', get_defined_vars());
    }

    public function lawyers_services(Request $request, $filter)
    {
        $query = Service::with([
            'user' => function ($query) {
                $query->where('document_status', 'approved');
            },
            'category'
        ])->whereHas('user', function ($query) {
            $query->where('document_status', 'approved');
        });
    
        if ($filter !== '0') {
            $query->where('categories_id', $filter);
        }
    
        if ($request->filled('price_order')) {
            $priceOrder = $request->price_order == 'asc' ? 'asc' : 'desc';
            $query->orderBy('amount', $priceOrder);
        }
    
        if ($request->filled('category_id')) {
            $query->where('categories_id', $request->category_id);
        }
    
        if ($request->filled('location')) {
            $query->whereHas('user', function ($query) use ($request) {
                $query->where('city', $request->location);
            });
        }
    
        $services = $query->paginate(9);
        // dd($services);
        $categories = Category::get();
    
        return view('front-layouts.pages.online_lawyers', compact('services', 'categories'));
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

    // help center
    public function help_center()
    {
        return view('front-layouts.pages.helpCenter.form');
    }

    public function help_center_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required',
            'complaint' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            HelpCenter::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'transaction_id' => $request->transaction_id,

                'complaint' => $request->complaint,
            ]);
            Session::flash('message', 'Your Complaint has been forwarded to the Support Successfully. We will contact you soon.');
            return redirect()->back();
        }
    }
}
