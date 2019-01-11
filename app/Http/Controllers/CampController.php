<?php

namespace App\Http\Controllers;

use App\Camp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $camps = Camp::getRegisterableCamps();
        return view('camp.show',compact('camps', 'user'));
    }
    
}
