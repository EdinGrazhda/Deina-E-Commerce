<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Return the view without data - Alpine.js will fetch data via API
        return view('welcome');
    }
}
