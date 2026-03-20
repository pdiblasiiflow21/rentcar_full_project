<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
   public function store(Request $request)
{
    $payment = Payment::create($request->all());

    $previous = Payment::where('rental_id', $payment->rental_id)
        ->where('id', '<', $payment->id)
        ->orderBy('id', 'desc')
        ->first();

    $km = null;

    if ($previous && $payment->km_reported) {
        $km = $payment->km_reported - $previous->km_reported;
    }

    return [
        'payment' => $payment,
        'km_traveled' => $km
    ];
}

public function index()
{
    return Payment::with('rental.driver', 'rental.vehicle')->get();
}
}
