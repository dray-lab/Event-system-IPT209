<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function getEvents()
    {
        $events = Event::with(['venue', 'user'])->get();
        return response()->json(['events' => $events], 200);
    }

    public function addEvent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'venue_id' => 'required|exists:venues,id',
            'status' => 'required|in:draft,published,cancelled',
            'ticket_price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'event_type' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event = Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'venue_id' => $request->venue_id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'ticket_price' => $request->ticket_price,
            'capacity' => $request->capacity,
            'event_type' => $request->event_type
        ]);

        return response()->json(['message' => 'Event created successfully', 'event' => $event], 201);
    }

    public function editEvent(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required',
            'end_time' => 'required',
            'venue_id' => 'required|exists:venues,id',
            'status' => 'required|in:draft,published,cancelled',
            'ticket_price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'event_type' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $event = Event::findOrFail($id);
        
        // Check if user owns the event
        if ($event->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->update($request->all());

        return response()->json(['message' => 'Event updated successfully', 'event' => $event], 200);
    }

    public function deleteEvent($id)
    {
        $event = Event::findOrFail($id);
        
        // Check if user owns the event
        if ($event->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $event->delete();

        return response()->json(['message' => 'Event deleted successfully'], 200);
    }
} 