<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

use App\Person;

use App\Mail\Testing;

use Illuminate\Support\Facades\Mail;

class TestingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        return print_r(\App\Person::quorum_count(), true );
    }

    public function mail()
    {
        Mail::to($request->user())->send(new Testing($order));
    }
        
}
