<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SocialAccountController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;

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

Route::get('/auth/redirect', [AuthController::class, 'authRedirect'])
    ->name('auth');

Route::get('/auth/callback', [AuthController::class, 'authCallback']);

Route::middleware('guest')->group(function () {
    Route::get('/', function () { return view('index'); })
        ->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    Route::get('/home', [PostController::class, 'index'])
        ->name('posts.index');
    
    Route::get('/posts/create', [PostController::class, 'create'])
        ->name('posts.create');

    Route::post('/posts', [PostController::class, 'store'])
        ->name('posts.store');
    
    Route::get('posts/{date}/edit', [PostController::class, 'edit'])
        ->name('posts.edit');
    
    Route::patch('posts/{date}', [PostController::class, 'update'])
        ->name('posts.update');

    Route::delete('/posts/{date}', [PostController::class, 'destroy'])
        ->name('posts.destroy');

    Route::get('/search', SearchController::class)
        ->name('search');
    
    Route::get('/settings', SettingController::class)
        ->name('settings');
    
    Route::post('/tags', [TagController::class, 'store'])
        ->name('tags.store');
    
    Route::patch('/tags/{tag}', [TagController::class, 'update'])
        ->name('tags.update');

    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])
        ->name('tags.destroy');
    
    Route::delete('/socialAccounts/{social_account}', [SocialAccountController::class, 'destroy'])
        ->name('socialAccounts.destroy');
    
    Route::get('/settings/accounterror', function () { return view('settings.error'); })
        ->name('accounterror');

    Route::get('/settings/userdelete', function () { return view('settings.delete'); })
        ->name('userdelete');

    Route::delete('users/{user_id}', [UserController::class, 'destroy'])
        ->name('users.destroy');
});
