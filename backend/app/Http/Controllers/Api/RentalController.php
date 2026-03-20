<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    public function index()
{
    return Rental::with(['driver','vehicle'])->get();
}

public function store(Request $request)
{
    return Rental::create($request->all());
}

public function debt($id)
{
    $rental = Rental::with('payments')->findOrFail($id);

    $start = \Carbon\Carbon::parse($rental->start_date);
    $now = \Carbon\Carbon::now();

    // calcular cantidad de periodos
    $weeks = $start->diffInWeeks($now);

    $expected = 0;

    if ($rental->type === 'semanal') {
        $expected = $weeks * $rental->amount;
    }

    if ($rental->type === 'quincenal') {
        $expected = floor($weeks / 2) * $rental->amount;
    }

    if ($rental->type === 'mensual') {
        $months = $start->diffInMonths($now);
        $expected = $months * $rental->amount;
    }

    $paid = $rental->payments->sum('amount');

    return [
        'expected' => $expected,
        'paid' => $paid,
        'debt' => $expected - $paid
    ];
}

}
