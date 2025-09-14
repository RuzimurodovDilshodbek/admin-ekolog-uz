<?php

if (!function_exists('localized_url')) {
    function localized_url($path, $parameters = [], $secure = null)
    {
        $locale = app()->getLocale();
        return url($locale . '/' . ltrim($path, '/'), $parameters, $secure);
    }
}


if (!function_exists('getLocaleForMonth')) {
    function getLocaleForMonth()
    {
        $locale = app()->getLocale();

        if ($locale == "uz") {
            return "uz-UZ";
        }
        return $locale;
    }
}

if (!function_exists("getYouTubeVideoId")) {
    function getYouTubeVideoId($pageVideUrl)
    {
        try {
            $link = $pageVideUrl;
            $video_id = explode("?v=", $link);
            if (!isset($video_id[1])) {
                $video_id = explode("youtu.be/", $link);
            }
            if (empty($video_id[1])) $video_id = explode("/v/", $link);
                $video_id = explode("&", $video_id[1] ?? "");
                $youtubeVideoID = $video_id[0];

            if(str_starts_with($pageVideUrl, 'https://youtu.be/')) {
                $arr = explode('?si=', $pageVideUrl);
                $youtubeVideoID = substr($arr[0], 17);
            }
            if(str_starts_with($pageVideUrl, 'https://www.youtube.com/live/')) {
                $arr = explode('?si=', $pageVideUrl);
                $youtubeVideoID = substr($arr[0], 29);
            }

            if ($youtubeVideoID) {
                return $youtubeVideoID;
            } else {
                return false;
            }
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}


if (!function_exists("getYouTubeVideoThumb")) {
    function getYouTubeVideoThumb($url)
    {
        $id = getYouTubeVideoId($url);
        $thumbURL = 'https://img.youtube.com/vi/' . $id . '/mqdefault.jpg';
        return $thumbURL;


    }
}

function changeLocaleInRoute(Illuminate\Routing\Route $route, $newLocale)
{
//    if($route)
    $route->setParameter('locale', $newLocale);
    return $route->getName();
}

function trs($string, $to_lang) {
    $c = new \Google\Cloud\Translate\V2\TranslateClient(['key' => 'AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw']);

    try {
        $response = $c->translate($string, ['format' => 'html', 'target' => $to_lang]);
        return $response['text'];
    } catch (Exception $e) {
        return false;
    }

}
function trsTitle($string, $to_lang) {
    $c = new \Google\Cloud\Translate\V2\TranslateClient(['key' => 'AIzaSyBOti4mM-6x9WDnZIjIeyEU21OpBXqWBgw']);

    try {
        $response = $c->translate($string, ['format' => 'text', 'target' => $to_lang]);
        return $response['text'];
    } catch (Exception $e) {
        return false;
    }

}

function transliterate($textcyr = null, $textlat = null)
{
    $cyr = array(
        'ё', 'ж', 'х', 'ц', 'ч', 'щ', 'ш', 'ъ', 'э', 'ю', 'я', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь', 'қ', 'ҳ', 'ў', 'ғ',
        'Ё', 'Ж', 'Х', 'Ц', 'Ч', 'Щ', 'Ш', 'Ъ', 'Э', 'Ю', 'Я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь', 'Қ', 'Ҳ', 'Ў', 'Ғ');
    $lat = array(
        'yo', 'j', 'x', 'ts', 'ch', 'sh', 'sh', '\'', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', '', 'q', 'h', 'o‘', 'g‘',
        'Yo', 'J', 'X', 'Ts', 'Ch', 'Sh', 'Sh', '\'', 'E', 'Yu', 'Ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', '', 'Q', 'H', 'O‘', 'G‘');
    if ($textcyr)
        return str_replace($cyr, $lat, $textcyr);
    else if ($textlat)
        return str_replace($lat, $cyr, $textlat);
    else
        return null;
}
function transliterateLatin($textcyr = null)
{
    $cyr = array(
        'ё', 'ж', 'х', 'ц', 'ч', 'щ', 'ш', 'ъ', 'э', 'ю', 'я', 'а', 'б', 'в', 'г', 'д', 'е', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'ь', 'қ', 'ҳ', 'ў', 'ғ',
        'Ё', 'Ж', 'Х', 'Ц', 'Ч', 'Щ', 'Ш', 'Ъ', 'Э', 'Ю', 'Я', 'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Ь', 'Қ', 'Ҳ', 'Ў', 'Ғ');
    $lat = array(
        'yo', 'j', 'x', 'ts', 'ch', 'sh', 'sh', '\'', 'e', 'yu', 'ya', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', '', 'q', 'h', 'o‘', 'g‘',
        'Yo', 'J', 'X', 'Ts', 'Ch', 'Sh', 'Sh', '\'', 'E', 'Yu', 'Ya', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', '', 'Q', 'H', 'O‘', 'G‘');
    if ($textcyr)
        return str_replace($cyr, $lat, $textcyr);
    else
        return null;
}
