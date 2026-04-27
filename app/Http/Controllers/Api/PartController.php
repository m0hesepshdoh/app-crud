<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Part;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PartController extends Controller
{
    public function index(Request $request)
    {
        $query = Part::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('keywords', 'like', "%{$search}%")
                    ->orWhere('part_number', 'like', "%{$search}%");
            });
        }

        return response()->json($query->latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'car_logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('car_logo')) {
            $path = $request->file('car_logo')->store('car-logos', 'public');
            $validated['car_logo'] = $path;
        }

        $part = Part::create($validated);

        return response()->json($part, 201);
    }

    public function show($id)
    {
        $part = Part::with('vehicles')->find($id);

        if (! $part) {
            return response()->json(['message' => 'Part not found'], 404);
        }

        return response()->json($part);
    }

    public function update(Request $request, $id)
    {
        $part = Part::find($id);

        if (! $part) {
            return response()->json(['message' => 'Part not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'part_number' => 'required|string|max:255',
            'description' => 'nullable|string',
            'keywords' => 'nullable|string',
            'car_logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('car_logo')) {
            
            if ($part->car_logo) {
                Storage::disk('public')->delete($part->car_logo);
            }
            $path = $request->file('car_logo')->store('car-logos', 'public');
            $validated['car_logo'] = $path;
        }

        $part->update($validated);

        return response()->json($part);
    }

    public function destroy($id)
    {
        $part = Part::find($id);

        if (! $part) {
            return response()->json(['message' => 'Part not found'], 404);
        }

        if ($part->car_logo) {
            Storage::disk('public')->delete($part->car_logo);
        }

        $part->delete();

        return response()->json(['message' => 'Part deleted successfully']);
    }

    public function linkVehicle(Request $request, $partId)
    {
        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'part_number_specific' => 'nullable|string',
            'reference_number' => 'nullable|string',
        ]);

        $vehicle = Vehicle::firstOrCreate([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
        ]);

        $part = Part::findOrFail($partId);

        if ($part->vehicles()->where('vehicle_id', $vehicle->id)->exists()) {
            return response()->json(['message' => 'Vehicle already linked'], 400);
        }

        $part->vehicles()->attach($vehicle->id, [
            'part_number_specific' => $validated['part_number_specific'] ?? null,
            'reference_number' => $validated['reference_number'] ?? null,
        ]);

        return response()->json(['message' => 'Vehicle linked successfully']);
    }

    public function updateVehicleLink(Request $request, $partId, $vehicleId)
    {
        $validated = $request->validate([
            'part_number_specific' => 'nullable|string',
            'reference_number' => 'nullable|string',
        ]);

        $part = Part::findOrFail($partId);

        $part->vehicles()->updateExistingPivot($vehicleId, [
            'part_number_specific' => $validated['part_number_specific'] ?? null,
            'reference_number' => $validated['reference_number'] ?? null,
        ]);

        return response()->json(['message' => 'Vehicle link updated successfully']);
    }

    public function unlinkVehicle($partId, $vehicleId)
    {
        $part = Part::findOrFail($partId);
        $part->vehicles()->detach($vehicleId);

        return response()->json(['message' => 'Vehicle unlinked successfully']);
    }

    public function getVehicles()
    {
        return response()->json(Vehicle::all());
    }

    public function updateVehicle(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (! $vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $validated = $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
        ]);

        $vehicle->update($validated);

        return response()->json($vehicle);
    }

    public function destroyVehicle($id)
    {
        $vehicle = Vehicle::find($id);

        if (! $vehicle) {
            return response()->json(['message' => 'Vehicle not found'], 404);
        }

        $vehicle->delete();

        return response()->json(['message' => 'Vehicle deleted successfully']);
    }
}
