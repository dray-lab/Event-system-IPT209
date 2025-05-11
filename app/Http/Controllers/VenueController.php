<?php

namespace App\Http\Controllers;

use App\Models\Venue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VenueController extends Controller
{
    public function getVenues()
    {
        $venues = Venue::with('user')->get();
        return response()->json(['venues' => $venues], 200);
    }

    public function addVenue(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $venue = Venue::create([
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
            'email' => $request->email,
            'capacity' => $request->capacity,
            'description' => $request->description,
            'status' => $request->status,
            'user_id' => auth()->id()
        ]);

        return response()->json(['message' => 'Venue created successfully', 'venue' => $venue], 201);
    }

    public function editVenue(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $venue = Venue::findOrFail($id);
        
        // Check if user owns the venue
        if ($venue->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $venue->update($request->all());

        return response()->json(['message' => 'Venue updated successfully', 'venue' => $venue], 200);
    }

    public function deleteVenue($id)
    {
        $venue = Venue::findOrFail($id);
        
        // Check if user owns the venue
        if ($venue->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $venue->delete();

        return response()->json(['message' => 'Venue deleted successfully'], 200);
    }
} 