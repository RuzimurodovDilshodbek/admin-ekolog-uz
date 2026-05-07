<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SiteInfo;

class SiteInfoController extends Controller
{
    public function show()
    {
        $info = SiteInfo::current();

        return response()->json([
            'data' => [
                'main_title'    => $info->main_title,
                'phone'         => $info->phone,
                'phone_link'    => $info->phone_link,
                'website'       => $info->website,
                'email'         => $info->email,
                'telegram_url'  => $info->telegram_url,
                'facebook_url'  => $info->facebook_url,
                'instagram_url' => $info->instagram_url,
                'address'       => $info->address,
                'transport'     => $this->splitLines($info->transport),
                'working_hours' => $this->splitLines($info->working_hours),
                'map_embed'     => $info->map_embed,
            ],
        ]);
    }

    private function splitLines(?string $value): array
    {
        if (!$value) return [];
        return collect(preg_split("/\r\n|\n|\r/", $value))
            ->map(fn ($l) => trim($l))
            ->filter()
            ->values()
            ->all();
    }
}
