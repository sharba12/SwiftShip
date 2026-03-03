<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parcel;

class MainPageController extends Controller
{
    public function landingPage()
    {
        return view('main.landing');
    }

    public function trackPage()
    {
        return view('main.track');
    }

    public function trackResult(Request $request)
{
    $request->validate([
        'tracking_number' => 'required'
    ]);

    // DB column is tracking_id, so use it
    $parcel = Parcel::where('tracking_id', $request->tracking_number)->first();

    return view('main.track-result', compact('parcel'));
}


    public function about()
    {
        return view('main.about');
    }

    public function services()
    {
        return view('main.services');
    }

    public function contact()
    {
        return view('main.contact');
    }
}
