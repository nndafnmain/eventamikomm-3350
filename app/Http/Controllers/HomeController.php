<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $events = Event::latest()->get();

        // $partners = Partner::latest()->get();

        return view('welcome', compact('events'));
    }
}
