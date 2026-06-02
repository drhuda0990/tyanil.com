<?php

namespace App\Http\Controllers;

use App\Rating;
use App\Http\Requests\StoreRatingRequest;
use App\Http\Requests\UpdateRatingRequest;
use Illuminate\Http\Request;
use Auth;
class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   public function ratingStore(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string'
    ]);

    Rating::updateOrCreate(
        [
            'customer_id' => Auth::guard('customer')->user()->id ,
            'service_id' => $request->service_id,
        ],
        [
            'stars' => $request->rating,
            'comment' => $request->comment,
            'status' => 1,
        ]
    );

        return back()->with('info', 'تم الحفظ والإرسال بنجاح');
}

    /**
     * Display the specified resource.
     */
    public function show(Rating $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rating $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRatingRequest $request, Rating $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rating $service)
    {
        //
    }
}
