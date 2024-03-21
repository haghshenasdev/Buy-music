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

Route::get('/', [\App\Http\Controllers\home::class,'index'])->name('home');
Route::get('help',function (){
    return view('help',['title' => 'راهنما']);
})->name('help');
Route::get('about',function (){
    return view('about',['title' => 'درباره ما']);
})->name('about');

Route::group(['prefix' => 'filemanager', 'middleware' => ['web', 'auth','can:admin']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/dashboard', function () {
    return view('dashboard.home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'dashboard','middleware' => ['auth']],function (){
    Route::get('profile', [\App\Http\Controllers\dashboard\Profile::class, 'index'])->name('profile');
    Route::post('profile', [\App\Http\Controllers\dashboard\Profile::class, 'update'])->name('UpdateProfile');
    Route::post('profile/cp', [\App\Http\Controllers\dashboard\Profile::class, 'changePass'])->name('changePass');

    Route::group(['middleware' => ['can:admin']],function (){
        Route::get('/new', [\App\Http\Controllers\dashboard\Musics::class,'new'])->name('newMusic');
        Route::post('/new', [\App\Http\Controllers\dashboard\Musics::class,'create'])->name('createMusic');
        Route::get('/show', [\App\Http\Controllers\dashboard\Musics::class,'show'])->name('MusicShowAndEdit');
        Route::post('/show', [\App\Http\Controllers\dashboard\Musics::class,'update'])->name('MusicUpdate');
        Route::delete('/delete', [\App\Http\Controllers\dashboard\Musics::class,'delete'])->name('deleteMusic');

        Route::group(['prefix' => 'setting'],function(){
            Route::get('/show', [\App\Http\Controllers\dashboard\Settings::class,'show'])->name('settingShow');
            Route::post('/show', [\App\Http\Controllers\dashboard\Settings::class,'update'])->name('settingUpdate');
        });

        Route::group(['prefix' => 'comments'],function(){
            Route::get('/', [\App\Http\Controllers\dashboard\Comments::class,'index'])->name('comments');
            Route::post('/show', [\App\Http\Controllers\dashboard\Comments::class,'update']);
        });

        Route::group(['prefix' => 'mailing'],function(){
            Route::get('/show', [MusicMailingController::class,'index'])->name('mailingShow');
            Route::post('/show', [MusicMailingController::class,'send']);
        });

        Route::group(['prefix' => 'users'],function (){
            Route::get('/', [\App\Http\Controllers\dashboard\Users::class, 'index'])->name('users');
            Route::get('show', [\App\Http\Controllers\dashboard\Users::class, 'show'])->name('showUser');
            Route::post('show', [\App\Http\Controllers\dashboard\Users::class, 'update'])->name('updateUser');
            Route::get('new', [\App\Http\Controllers\dashboard\Users::class, 'new'])->name('newUser');
            Route::post('new', [\App\Http\Controllers\dashboard\Users::class, 'create'])->name('createUser');
            Route::delete('delete', [\App\Http\Controllers\dashboard\Users::class, 'delete'])->name('deleteUser');
        });

        Route::group(['prefix' => 'buys'],function(){
            Route::get('/', [\App\Http\Controllers\dashboard\Buys::class,'index'])->name('buys');
        });
    });

});

require __DIR__.'/auth.php';

Route::post('/comment', [\App\Http\Controllers\home::class,'comment'])->name('comment')->middleware('auth');
Route::get('/{slug}', [\App\Http\Controllers\home::class,'show'])->name('show');
Route::post('/{slug}', [\App\Http\Controllers\home::class,'pay']);
Route::get('verify/{slug}', [\App\Http\Controllers\home::class,'verify'])->name('verify');
Route::get('{slug}/download/{fileId?}', [\App\Http\Controllers\home::class,'download'])->name('dl')->middleware('auth');

