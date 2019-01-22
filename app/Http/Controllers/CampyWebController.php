<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\CampyWeb;

class CampyWebController extends Controller
{
    public function camp_registration(Request $request) {
        $validator = Validator::make($request->all(), [
            'mobile' => 'required',
            'fullname' => 'required',
            'event' => 'required',
            'tos' => 'required|accepted',
        ]);
        if($validator->fails()) {
            return getErrorPath($request);
        }
        saveRequestToDatabase($request, [
            'mobile',
            'fullname',
            'event',
            'tos',
        ]);
        return getReturnPath($request);
    }

    public function gewinnspiel(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
        ]);
        if($validator->fails()) {
            return getErrorPath($request);
        }
        saveRequestToDatabase($request, [
            'name',
            'email',
        ]);
        return getReturnPath($request);
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

    public function getErrorPath(Request $request) {
        $url = $request->error_path ?? 'https://code.design/';
        return redirect()->away($url);
    }
}
