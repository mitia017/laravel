<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index ()
    {
        $properties = Property::limit(4)->dispo()->recent()->get();
        return view('home', [
            'properties' => $properties
        ]);
    }
}
