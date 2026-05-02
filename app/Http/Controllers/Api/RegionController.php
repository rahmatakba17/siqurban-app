<?php

namespace App\Http\Controllers\Api;

use App\Models\Region;
use Illuminate\Http\Request;

class RegionController
{
    public function index()
    {
        return response()->json(Region::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:regions',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $region = Region::create($validated);
        return response()->json($region, 201);
    }

    public function update(Request $request, Region $region)
    {
        $validated = $request->validate([
            'name' => 'required|unique:regions,name,' . $region->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $region->update($validated);
        return response()->json($region);
    }

    public function destroy(Region $region)
    {
        $region->delete();
        return response()->json(['message' => 'Wilayah berhasil dihapus']);
    }
}
