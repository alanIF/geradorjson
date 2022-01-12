<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Base;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Illuminate\Support\Facades\Storage;
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::id();

        $sql = 'Select * from base b where b.user_id='.$user.'';
        $bases = \DB::select($sql);
        
        return view('base.index', ['bases' => $bases]);    }
}
