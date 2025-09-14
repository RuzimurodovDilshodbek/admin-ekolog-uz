<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use App\Models\Management;


class ManagementController
{

    public function disabledSite(Request $request) {
            if ($request->data == 'true') {
                Artisan::call( 'down', [
                    '--secret' => '4BvJa03mkl-KPAyAqaK7y-Y7npFyywo3'
                ] );
                Management::query()->delete();
                $management = Management::create([
                    'site_status' => 0
                ]);
                return response()->json(['data' => $management]);
            }
             if ($request->data == 'false'){
                Artisan::call('up');

                Management::query()->delete();
               $management = Management::create([
                    'site_status' => 1
                ]);
                return response()->json(['data' => $management]);
            }
        }
}
