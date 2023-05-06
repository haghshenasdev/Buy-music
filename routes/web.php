<?php

use App\Http\Controllers\dashboard\MusicMailingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'dashboard','middleware' => ['auth','can:admin']],function (){
    Route::get('profile', [\App\Http\Controllers\dashboard\Profile::class, 'index'])->name('profile');
    Route::post('profile', [\App\Http\Controllers\dashboard\Profile::class, 'update'])->name('UpdateProfile');
    Route::post('profile/cp', [\App\Http\Controllers\dashboard\Profile::class, 'changePass'])->name('changePass');

    Route::get('/new', [\App\Http\Controllers\dashboard\Musics::class,'new'])->name('newMusic');
    Route::post('/new', [\App\Http\Controllers\dashboard\Musics::class,'create'])->name('newMusic');
    Route::get('/show', [\App\Http\Controllers\dashboard\Musics::class,'show'])->name('MusicShowAndEdit');
    Route::post('/show', [\App\Http\Controllers\dashboard\Musics::class,'update'])->name('MusicShowAndEdit');
    Route::delete('/delete', [\App\Http\Controllers\dashboard\Musics::class,'delete'])->name('deleteMusic');

    Route::group(['prefix' => 'setting'],function(){
        Route::get('/show', [\App\Http\Controllers\dashboard\Settings::class,'show'])->name('settingShow');
        Route::post('/show', [\App\Http\Controllers\dashboard\Settings::class,'update'])->name('settingShow');
    });

    Route::group(['prefix' => 'mailing'],function(){
        Route::get('/show', [MusicMailingController::class,'index'])->name('mailingShow');
        Route::post('/show', [MusicMailingController::class,'send']);
    });
});

require __DIR__.'/auth.php';

Auth::routes();

Route::post('/comment', [\App\Http\Controllers\home::class,'comment'])->name('comment')->middleware('auth');
Route::get('/', [\App\Http\Controllers\home::class,'index'])->name('home');
Route::get('/{slug}', [\App\Http\Controllers\home::class,'show'])->name('show');
Route::post('/{slug}', [\App\Http\Controllers\home::class,'pay']);
Route::get('verify/{slug}', [\App\Http\Controllers\home::class,'verify'])->name('verify');
Route::get('{slug}/download', [\App\Http\Controllers\home::class,'download'])->name('dl')->middleware('auth');

