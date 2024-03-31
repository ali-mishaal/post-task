<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SocialAuthController;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::post('/set-locale', function (Request $request) {
    $locale = $request->input('locale');
    \Illuminate\Support\Facades\Session::put('lang', $locale);

    return redirect()->back();
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::controller(PostController::class)
        ->group(function (){
            Route::get('/', 'index')->name('timeline');
            Route::post('posts', 'store')->name('posts.store');
            Route::post('posts/{post}', 'update')->name('posts.update');
            Route::delete('posts/{post}', 'destroy')->name('posts.destroy');
        });

    Route::resource('comments', CommentController::class)->only(['store']);
    Route::post('comments/bulk-destroy', [CommentController::class, 'bulkDestroy'])->name('comments.bulk.destroy');

});

Route::get('/login/facebook', [SocialAuthController::class, 'redirectToFacebook'])->name('login.facebook');
Route::get('/login/facebook/callback', [SocialAuthController::class, 'handleFacebookCallback']);
