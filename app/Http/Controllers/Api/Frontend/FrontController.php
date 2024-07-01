<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\HelpCenter;
use App\Models\Location;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function categories()
    {
        $categories = Category::paginate(10);

        return response()->json($categories, 200);
    }

    public function category_lawyers($id, $perPage = 10): JsonResponse
    {
        $validatedData = request()->validate([
            'perPage' => ['integer', 'min:1'],
        ]);

        $perPage = $validatedData['perPage'] ?? $perPage;

        $currentPage = request()->input('page', 1);

        $services = Service::where('categories_id', $id)
        ->whereHas('user', function ($query) {
            $query->where('document_status', 'approved');
        })
        ->with('user')
        ->paginate($perPage, ['*'], 'page', $currentPage);

        return response()->json($services, 200);
    }

    public function cities()
    {
        $cities = Location::get();
        if ($cities->count() > 0) {
            return response()->json(['message' => 'List of cities', 'cities' => $cities], 200);
        } else {
            return response()->json(['error' => 'No cities found'], 500);
        }
    }

    public function setting()
    {
        $setting = Setting::first();
        if ($setting) {
            return response()->json(['message' => 'setting', 'setting' => $setting], 200);
        } else {
            return response()->json(['error' => 'No setting found'], 500);
        }
    }

    public function help_center_submit(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'phone' => 'required',
            'complaint' => 'required',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422); // Unprocessable Entity status code
        }

        // If validation passes, create a new help center entry
        $helpCenter = HelpCenter::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'complaint' => $request->complaint,
        ]);

        // Flash message for success
        Session::flash('message', 'Your Complaint has been forwarded to the Support Successfully. We will contact you soon.');

        // Return success response
        return response()->json([
            'success' => true,
            'data' => $helpCenter,
            'message' => 'Your Complaint has been forwarded to the Support Successfully. We will contact you soon.',
        ], 200); // OK status code
    }
}
