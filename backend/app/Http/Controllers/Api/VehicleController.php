<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        return Vehicle::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'plate' => 'required|string|max:30|unique:vehicles,plate',
            'year' => 'nullable|integer',
            'has_gnc' => 'nullable|boolean',
        ]);

        return Vehicle::create($data);
    }

    public function show($id)
    {
        return Vehicle::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $v = Vehicle::findOrFail($id);
        $data = $request->validate([
            'brand' => 'nullable|string|max:100',
            'model' => 'nullable|string|max:100',
            'plate' => 'sometimes|string|max:30|unique:vehicles,plate,' . $id,
            'year' => 'nullable|integer',
            'has_gnc' => 'nullable|boolean',
        ]);

        $v->update($data);
        return $v;
    }

    public function destroy($id)
    {
        Vehicle::destroy($id);
    }
}

