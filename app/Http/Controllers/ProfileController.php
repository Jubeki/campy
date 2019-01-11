<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class UserController extends Controller
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
     * Show the profile dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diets = [
            0 => 'normal',
            1 => 'vegetarian',
            2 => 'vegan',
            3 => 'halal',
            4 => 'glutenfree',
            5 => 'lactosefree'
        ];        
        
        $user = Auth::user();
        $selected_diet = $user->diet;
        return view('home',compact('user', 'selected_diet', 'diets'));
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $passedID = Str::after($request->path(), '/');
        $loggedUser = Auth::user()->id;
        $age = Auth::user()->age;

        if ($passedID == $loggedUser) {
            if ($age < 18 and $age != 0) {
                $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'birthdate' => 'required',
                'diet' => 'required',
                'mobile' => 'required',
                'zip' => 'required|numeric|regex:/\d{5}/',
                'guardian_firstname' => 'required',
                'guardian_lastname' => 'required',
                'guardian_email' => 'required',
                'guardian_phone' => 'required',
            ]);
            }

            else {
            $this->validate($request, [
                'firstname' => 'required',
                'lastname' => 'required',
                'birthdate' => 'required',
                'diet' => 'required',
                'mobile' => 'required',
                'zip' => 'required|numeric|regex:/\d{5}/'
            ]);
        }

            $user->firstname = $request->firstname;
            $user->lastname = $request->lastname;
            $user->birthdate = $request->birthdate;
            $user->diet = $request->diet;
            $user->mobile = $request->mobile;
            $user->instagram = $request->instagram;
            $user->twitter = $request->twitter;
            $user->zip = $request->zip;
            $user->guardian_firstname = $request->guardian_firstname;
            $user->guardian_lastname = $request->guardian_lastname;
            $user->guardian_email = $request->guardian_email;
            $user->guardian_phone = $request->guardian_phone;
            $user->complete = 1;
            $user->save();

            return redirect('camps');
        } else {
            Session::flash('info', 'Denkste! Du kannst natürlich nur deine eigenen Daten ändern…');
            return redirect('profile');
        }

    }
}
