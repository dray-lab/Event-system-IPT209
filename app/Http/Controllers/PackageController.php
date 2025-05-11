<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PackageController extends Controller
{
    public function getPackages()
    {
        $packages = Package::with(['event', 'user'])->get();
        return response()->json(['packages' => $packages], 200);
    }

    public function addPackage(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:active,inactive',
            'max_tickets' => 'required|integer|min:1',
            'available_tickets' => 'required|integer|min:0|lte:max_tickets'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = Package::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration' => $request->duration,
            'features' => $request->features,
            'event_id' => $request->event_id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'max_tickets' => $request->max_tickets,
            'available_tickets' => $request->available_tickets
        ]);

        return response()->json(['message' => 'Package created successfully', 'package' => $package], 201);
    }

    public function editPackage(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|string|max:255',
            'features' => 'required|array',
            'event_id' => 'required|exists:events,id',
            'status' => 'required|in:active,inactive',
            'max_tickets' => 'required|integer|min:1',
            'available_tickets' => 'required|integer|min:0|lte:max_tickets'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $package = Package::findOrFail($id);
        
        // Check if user owns the package
        if ($package->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $package->update($request->all());

        return response()->json(['message' => 'Package updated successfully', 'package' => $package], 200);
    }

    public function deletePackage($id)
    {
        $package = Package::findOrFail($id);
        
        // Check if user owns the package
        if ($package->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $package->delete();

        return response()->json(['message' => 'Package deleted successfully'], 200);
    }
} 