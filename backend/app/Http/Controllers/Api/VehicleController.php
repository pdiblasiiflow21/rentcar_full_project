<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
{
    return Vehicle::all();
}

public function store(Request $request)
{
    return Vehicle::create($request->all());
}

public function show($id)
{
    return Vehicle::findOrFail($id);
}

public function update(Request $request, $id)
{
    $v = Vehicle::findOrFail($id);
    $v->update($request->all());
    return $v;
}

public function destroy($id)
{
    Vehicle::destroy($id);
}
}
