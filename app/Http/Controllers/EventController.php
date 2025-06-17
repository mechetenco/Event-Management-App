<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class EventController extends Controller
{
    protected $apiBaseUrl = 'http://localhost:8000/api';

    public function index()
    {
        
        $response = Http::get("{$this->apiBaseUrl}/events");
        $events = $response->successful() ? $response->json('data') : [];

        return view('events.index', compact('events'));
    }

  public function show($id)
{
    $eventResponse = Http::get("{$this->apiBaseUrl}/events/{$id}");

    if (!$eventResponse->successful() || !$eventResponse->json('data')) {
        return redirect()->route('events.index')->with('error', 'Event not found.');
    }

    $event = $eventResponse->json('data');

    $attendeeResponse = Http::get("{$this->apiBaseUrl}/events/{$id}/attendees", [
        'include' => 'user'
    ]);
    $attendees = $attendeeResponse->json('data') ?? [];

    return view('events.show', compact('event', 'attendees'));
}



     
    public function create()
    {
        
        return view('events.create');
    }

    public function store(Request $request)
    {

         if (!session('api_token')) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
        ]);

        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $response = Http::withToken($token)->post("{$this->apiBaseUrl}/events", $request->only([
            'name', 'description', 'start_time', 'end_time'
        ]));

        if ($response->successful()) {
            return redirect()->route('events.index')->with('success', 'Event created successfully.');
        }

        return back()->with('error', 'Failed to create event.')->withInput();
    }

    public function edit($id)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $response = Http::withToken($token)->get("{$this->apiBaseUrl}/events/{$id}");
        $event = $response->json('data');

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, $id)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $response = Http::withToken($token)
            ->put("{$this->apiBaseUrl}/events/{$id}", $request->only([
                'name', 'description', 'start_time', 'end_time'
            ]));

        if ($response->successful()) {
            return redirect()->route('events.index')->with('success', 'Event updated.');
        }

        return back()->with('error', 'Failed to update event.');
    }

    public function destroy($id)
    {
        $token = session('api_token');
        if (!$token) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $response = Http::withToken($token)
            ->delete("{$this->apiBaseUrl}/events/{$id}");

        if ($response->successful()) {
            return redirect()->route('events.index')->with('success', 'Event deleted.');
        }

        return back()->with('error', 'Failed to delete event.');
    }


   public function attend($id)
{
    $token = session('api_token');

    if (!$token) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }

    $response = Http::withToken($token)->post("http://localhost:8000/api/events/{$id}/attendees");

    if ($response->successful()) {
        return redirect()->back()->with('success', 'You have successfully registered for the event.');
    }

    return redirect()->back()->with('error', 'Failed to attend event.');
}


public function unattend($eventId, $attendeeId)
{
    $token = session('api_token');

    if (!$token) {
        return redirect()->route('login')->with('error', 'Please login first.');
    }

       $response = Http::withToken($token)->delete("http://localhost:8000/api/events/{$eventId}/attendees/{$attendeeId}");


    if ($response->successful()) {
        return redirect()->back()->with('success', 'You have successfully unattended the event.');
    }

    return redirect()->back()->with('error', 'Failed to unattend event.');
}

}
