<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\IdeaController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {

    return Auth::check() ? redirect()->route('ideas.index') : redirect()->route('login');
});

Auth::routes();

Route::resource('ideas', IdeaController::class)->middleware('auth');

Route::get('/articles', [HomeController::class, 'articles'])->name('articles')->middleware('auth');

Route::get('/email-test', function () {
    $details['email'] = 'mjuyelrana@gmail.com';
    $details['name'] = 'Md Juyel Rana';

    dispatch(new \App\Jobs\SendAddIdeaEmailJob($details));

    dd('Send Email Successfully');
});
