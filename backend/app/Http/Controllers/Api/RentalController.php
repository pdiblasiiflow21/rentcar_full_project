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
}
