<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DriverController extends Controller
{
   public function index()
{
    return Driver::all();
}

public function store(Request $request)
{
    return Driver::create($request->all());
}
}
