<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;
use Illuminate\Http\Request;

class SiteInfoController extends Controller
{
    public function edit()
    {
        $siteInfo = SiteInfo::current();
        return view('admin.site-info.edit', compact('siteInfo'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'main_title'    => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:255'],
            'phone_link'    => ['nullable', 'string', 'max:255'],
            'website'       => ['nullable', 'string', 'max:255'],
            'email'         => ['nullable', 'string', 'max:255'],
            'telegram_url'  => ['nullable', 'string', 'max:255'],
            'facebook_url'  => ['nullable', 'string', 'max:255'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'address'       => ['nullable', 'string'],
            'transport'     => ['nullable', 'string'],
            'working_hours' => ['nullable', 'string'],
            'map_embed'     => ['nullable', 'string'],
        ]);

        $siteInfo = SiteInfo::current();
        $siteInfo->update($data);

        return redirect()->route('admin.site-info.edit')->with('status', 'Saqlandi');
    }
}
