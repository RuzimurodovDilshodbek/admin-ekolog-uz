<?php

namespace App\Http\Controllers\Admin;

use App\Models\Management;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class HomeController
{
    public function index()
    {
        $site_status = Management::query()->first()?->site_status;
        return view('home',compact( 'site_status'));
    }

    public function translate(Request $request) {
        $data = [];
        foreach (config('app.locales') as $key_local => $value_local) {
            if($value_local !== 'kr') {
                $translated = trs($request->data, $value_local);
                array_push($data, $translated);
            }
        }

        return response()->json(['data' => $data]);
    }
    public function translateTitle(Request $request) {
        $data = [];
        foreach (config('app.locales') as $key_local => $value_local) {
            if($value_local !== 'kr' && $value_local !== 'uz') {
                $translated = trsTitle($request->data, $value_local);
                array_push($data, $translated);
            }
            if($value_local == 'uz') {
                $translated = transliterateLatin($request->data);
                array_push($data, $translated);
            }
        }

        return response()->json(['data' => $data]);
    }
}
