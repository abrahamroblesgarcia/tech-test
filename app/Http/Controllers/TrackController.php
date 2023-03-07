<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contexts\Track as TrackContext;

class TrackController extends Controller
{
    public function index(Request $request)
    {
        $tracks = new TrackContext($request->user()->id);
        $tracks = $tracks->getAll();

        return response()->json($tracks);
    }
}
