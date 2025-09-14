<?php

use App\Http\Controllers\Api\Auth\AuthController;
use \Illuminate\Support\Facades\Route;


Route::get("/", [\App\Http\Controllers\Web\HomeController::class, 'home']);


Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', \App\Http\Middleware\SetLocale::class]], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Section
    Route::delete('sections/destroy', 'SectionController@massDestroy')->name('sections.massDestroy');
    Route::resource('sections', 'SectionController');

    // Tag
    Route::delete('tags/destroy', 'TagController@massDestroy')->name('tags.massDestroy');
    Route::resource('tags', 'TagController');

    //Vidio
    Route::resource('videos', 'VideoController');
    Route::get('video/editSort', 'VideoController@editSort')->name('videoEditSort');
    Route::put('video/updateSort', 'VideoController@updateSort')->name('videoUpdateSort');

    Route::get('video/editSort', 'VideoController@editSort')->name('videoEditSort');

    //Vidio
    Route::resource('video-category', 'VideoCategoryController');

    // Post
    Route::put('posts/archiving', 'PostController@massArchiving')->name('posts.massArchiving');
    Route::put('posts/un-archiving', 'PostController@massUnArchiving')->name('posts.massUnArchiving');
    Route::post('posts/media', 'PostController@storeMedia')->name('posts.storeMedia');
    Route::post('posts/ckmedia', 'PostController@storeCKEditorImages')->name('posts.storeCKEditorImages');
    Route::resource('posts', 'PostController');
    Route::resource('quotations', 'QuotationController');

    Route::get('post/archived', 'PostController@archived')->name('post.archived');
    Route::get('post/getSectionId', 'PostController@getSectionId')->name('postGetSectionId');
    Route::get('post/getSectionIdEdit', 'PostController@getSectionIdEdit')->name('postGetSectionIdEdit');


    // Tutor
    Route::delete('tutors/destroy', 'TutorController@massDestroy')->name('tutors.massDestroy');
    Route::post('tutors/media', 'TutorController@storeMedia')->name('tutors.storeMedia');
    Route::post('tutors/ckmedia', 'TutorController@storeCKEditorImages')->name('tutors.storeCKEditorImages');
    Route::resource('tutors', 'TutorController');

    // Banner Post
    Route::delete('banner-posts/destroy', 'BannerPostController@massDestroy')->name('banner-posts.massDestroy');
    Route::post('banner-posts/media', 'BannerPostController@storeMedia')->name('banner-posts.storeMedia');
    Route::post('banner-posts/ckmedia', 'BannerPostController@storeCKEditorImages')->name('banner-posts.storeCKEditorImages');
    Route::resource('banner-posts', 'BannerPostController');

    // Dailiy Verse
    Route::delete('dailiy-verses/destroy', 'DailiyVerseController@massDestroy')->name('dailiy-verses.massDestroy');
    Route::resource('dailiy-verses', 'DailiyVerseController');

    // Tutor Opinion
    Route::delete('tutor-opinions/destroy', 'TutorOpinionController@massDestroy')->name('tutor-opinions.massDestroy');
    Route::post('tutor-opinions/media', 'TutorOpinionController@storeMedia')->name('tutor-opinions.storeMedia');
    Route::post('tutor-opinions/ckmedia', 'TutorOpinionController@storeCKEditorImages')->name('tutor-opinions.storeCKEditorImages');
    Route::resource('tutor-opinions', 'TutorOpinionController');

    // Post Views
    Route::delete('post-views/destroy', 'PostViewsController@massDestroy')->name('post-views.massDestroy');
    Route::resource('post-views', 'PostViewsController');
    Route::get('post-views-show', 'PostViewsShowController@index')->name('post-views-show.index');

    // Post Comment
    Route::delete('post-comments/destroy', 'PostCommentController@massDestroy')->name('post-comments.massDestroy');
    Route::resource('post-comments', 'PostCommentController');

    // Poll
    Route::delete('polls/destroy', 'PollController@massDestroy')->name('polls.massDestroy');
    Route::resource('polls', 'PollController');

    // Poll Variant
    Route::delete('poll-variants/destroy', 'PollVariantController@massDestroy')->name('poll-variants.massDestroy');
    Route::resource('poll-variants', 'PollVariantController');

    // Poll Votes
    Route::delete('poll-votes/destroy', 'PollVotesController@massDestroy')->name('poll-votes.massDestroy');
    Route::resource('poll-votes', 'PollVotesController');

    // Favourites
    Route::delete('favourites/destroy', 'FavouritesController@massDestroy')->name('favourites.massDestroy');
    Route::resource('favourites', 'FavouritesController');

    // Ad
    Route::delete('ads/destroy', 'AdController@massDestroy')->name('ads.massDestroy');
    Route::post('ads/media', 'AdController@storeMedia')->name('ads.storeMedia');
    Route::post('ads/ckmedia', 'AdController@storeCKEditorImages')->name('ads.storeCKEditorImages');
    Route::resource('ads', 'AdController');

    // Ad Views
    Route::delete('ad-views/destroy', 'AdViewsController@massDestroy')->name('ad-views.massDestroy');
    Route::resource('ad-views', 'AdViewsController');

    // Newsletters
    Route::delete('newsletters/destroy', 'NewslettersController@massDestroy')->name('newsletters.massDestroy');
    Route::resource('newsletters', 'NewslettersController');

});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth', \App\Http\Middleware\SetLocale::class]], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }

});


