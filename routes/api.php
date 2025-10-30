<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Mail\InvoiceCreatedMail;
use App\Mail\SendRegisterLinkMail;
use App\Mail\SendResetPassLinkMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api', ], function () {
    Route::get('home/get-full-resource', 'HomeController@getNewsHome');
    Route::get('get-post/{id}', 'HomeController@getPostId');
    Route::get('get-category/{id}', 'HomeController@getCategoryId');
    Route::get('get-category-intervyu', 'HomeController@getIntervyuCategory');
    Route::get('get-search', 'HomeController@getSearch');
    Route::get('get-tag/{id}', 'HomeController@getTags');
});


Route::post("/poll-voting", [\App\Http\Controllers\Web\PollController::class, "pollVoting"]);
Route::post("/news/list-action-items", [\App\Http\Controllers\Web\HomeController::class, "getNewsList"]);
Route::get("/newsletter", [\App\Http\Controllers\Web\HomeController::class, "newsletter"]);
Route::post("/translate", [\App\Http\Controllers\Admin\HomeController::class, "translate"])->name('translate');
Route::post("/translate-title", [\App\Http\Controllers\Admin\HomeController::class, "translateTitle"])->name('translateTitle');
Route::post("/disabled-site", [\App\Http\Controllers\Admin\ManagementController::class, "disabledSite"])->name('disabledSite');
Route::post("/trs-tag-create",[ \App\Http\Controllers\Admin\TagController::class,"trsTagCreate"])->name('tags.trsTagCreate');
//Route::post("post/getSectionId",[ \App\Http\Controllers\Admin\PostController::class,"getSectionId"])->name('postGetSectionId');
//Route::get('post/getSectionId', 'PostController@getSectionId')->name('postGetSectionId');


Route::group(['prefix' => 'v2', 'as' => 'api.', 'namespace' => 'Api'], function () {
    Route::get('resources/get-sections', 'ResourceController@getSections');
    Route::get('home/get-news-home', 'HomeController@getNewsHome');
    Route::get('get-post/{id}', 'HomeController@getPostId');
    Route::get('get-category/{id}', 'HomeController@getCategoryId');
    Route::get('get-search', 'HomeController@getSearch');
    Route::get('get-videos', 'HomeController@getVideos');
    Route::get('get-tag/{id}', 'HomeController@getTags');
    Route::post('auth/login',[AuthController::class,'login']);
    Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);
    Route::post('auth/register', [AuthController::class,'register']);


});
Route::group(['prefix' => 'v1'], function () {
    Route::get('posts', [PostController::class, 'index']);
});
Route::post('/send-invoice-email', function (Request $request) {


    $invoices = $request->invoices;
    $pdfs = $request->pdfs;
    $to = $request->email;
    $current_user_name = $request->current_user_name;

    if (empty($invoices) || empty($pdfs) || empty($to) || empty($current_user_name)) {
        return response()->json(['message' => 'Invalid data'], 400);
    }
    Mail::to($to)->send(new InvoiceCreatedMail($invoices, $pdfs,$current_user_name));

    return response()->json(['message' => 'Email sent successfully']);
});
Route::post('/send-register-link-mail', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'to' => 'required|email',
    ]);

    $token = $request->token;
    $to = $request->to;

    Mail::to($to)->send(new SendRegisterLinkMail($token));

    return response()->json(['message' => 'Email sent successfully']);
});
Route::post('/send-reset-pass-link-mail', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'to' => 'required|email',
    ]);

    $token = $request->token;
    $to = $request->to;

    Mail::to($to)->send(new SendResetPassLinkMail($token));

    return response()->json(['message' => 'Email sent successfully']);
});
