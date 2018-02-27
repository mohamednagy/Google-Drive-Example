<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = $request->page ?? 1;

        $page = $request->has('page') ? $request->query('page') : 1;
        
        $files = Cache::remember('files_' . auth()->user()->id . '_' . $page, 30, function() {
            return auth()->user()->files()->paginate(30);
        });

        return view('home')->with('files', $files);
    }
}
