<?php

namespace App\Http\Controllers;

use App\Models\property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index ()
    {
        $properties = property::limit(4)->dispo()->recent()->get();
        return view('home', [
            'properties' => $properties
        ]);
    }
}
