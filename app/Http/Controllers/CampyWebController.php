<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CampyWeb;

class CampyWebController extends Controller
{
    public function camp_registration(Request $request) {

    }

    public function gewinnspiel(Request $request) {

    }

    public function magazin(Request $request) {

    }

    public function kontakt(Request $request) {

    }

    public function interest(Request $request) {

    }

    public function saveRequestToDatabase(Request $request, $parameters) {
        $values = $request->only($parameters);
        CampyWeb::insert($values);
    }

    public function getReturnPath(Request $request) {
        $url = $request->return_path ?? 'https://code.design/';
        return redirect()->away($url);
    }
}
