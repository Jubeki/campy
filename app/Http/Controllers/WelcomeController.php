<?php

namespace App\Http\Controllers;

use App\Camp;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $camps = Camp::getRegisterableCamps();
        return view('welcome',compact('camps'));
    }
}
