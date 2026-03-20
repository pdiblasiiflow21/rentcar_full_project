<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return Driver::all();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'dni' => 'nullable|string|max:50',
            'license_number' => 'nullable|string|max:255',
            'license_expiration' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'documents' => 'nullable|array|max:4',
            'documents.*' => 'file|mimes:jpg,jpeg,png,gif,pdf|max:20480',
        ]);

        $documents = [];

        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $index => $file) {
                $path = $file->store('drivers/documents', 'public');
                $documents[] = $path;
            }
        }

        $data['documents'] = $documents;

        $driver = Driver::create($data);

        // Retornar URL de documento para frontend
        $driver->documents = collect($documents)->map(fn($path) => asset('storage/'.$path));

        return $driver;
    }
}
