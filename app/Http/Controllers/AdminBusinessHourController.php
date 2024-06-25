<?php

namespace App\Http\Controllers;

use App\Models\BusinessHour;
use Illuminate\Http\Request;

class AdminBusinessHourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $paginationCount = 20;
        $businessHours = BusinessHour::paginate($paginationCount);
        return view('admin.business_hours.index', compact('businessHours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $startDate = new \DateTime('2024-01-01');
        $endDate = new \DateTime('2026-01-01');
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        foreach ($period as $date) {
            $dayOfWeek = $date->format('N'); // 1 (for Monday) through 7 (for Sunday)
            if ($dayOfWeek < 6) { // Exclude weekends
                BusinessHour::create([
                    'day' => $date->format('Y-m-d'),
                    'from' => '09:00:00',
                    'to' => '17:00:00',
                    'step' => 30,
                    'off' => false,
                ]);
            }
        }

        return redirect()->route('admin.business_hour.index');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
