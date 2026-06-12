<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    //
    public function show($id)
    {
        $event = Event::with('category')->findOrFail($id);

        return view('event-detail', compact('event'));
    }

    public function checkout()
    {
        return view('checkout');
    }
}
