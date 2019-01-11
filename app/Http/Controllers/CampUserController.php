<?php

namespace App\Http\Controllers;

use App\Camp;
use App\CampUser;
use App\Mail\ContributionConfirmed;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CampUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateTransaction(Request $request, $camp, $user, CampUser $campuser){

        $userProfile = User::where('id','=',$user)->first();

        $camp_user = \App\CampUser::where([
                    ['user_id', '=', $user],
                    ['camp_id', '=', $camp],
                ])->first();

        if ($camp_user->status == 'registered') {
            $camp_user->status = 'confirmed';
            $camp_user->save();

        }

        if ($userProfile->age < 18)
        {
           Mail::to($userProfile->email)
            ->cc($userProfile->guardian_email)
            ->send(new ContributionConfirmed($camp)); 
        }
        else {
           Mail::to($userProfile->email)
            ->send(new ContributionConfirmed($camp)); 
        }
    
        
        return redirect()->back();
    }

    public function updateLaptopTransaction(Request $request, $camp, $user){

        $camp_user = \App\CampUser::where([
                    ['user_id', '=', $user],
                    ['camp_id', '=', $camp],
                ])->first();

        if ($camp_user->laptop == 'payer') {
            $camp_user->laptop = 'paid';
            $camp_user->save();

        }
    
        return redirect()->back();
    }

    public function cancelParticipation(Request $request, $camp, $user){
        $camp_user = \App\CampUser::where([
                    ['user_id', '=', $user],
                    ['camp_id', '=', $camp],
                ])->first();
        $camp_user->status = 'cancelled';
        $camp_user->save();
        return back();
    }

}