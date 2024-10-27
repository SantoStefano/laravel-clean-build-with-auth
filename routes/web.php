<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompetencyGroupController;
use App\Http\Controllers\CompetencyController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AdminController;

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

// Route::get('/', function () {
//     return view('welcome');
// });



Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', function () {
        return view('secret');
     })->middleware('password.confirm');

    // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/secret', function () {
        return view('secret');
     })->name('secret');

});


// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Группы компетенций
Route::get('/competency-groups', [CompetencyGroupController::class, 'index'])->name('competency-groups.index');
Route::get('/competency-groups/{id}', [CompetencyGroupController::class, 'show'])->name('competency-groups.show');

// Компетенции
Route::get('/competencies/{id}', [CompetencyController::class, 'show'])->name('competencies.show');

// Площадки
Route::get('/platforms/{id}', [PlatformController::class, 'show'])->name('platforms.show');

// Заявки
Route::get('/applications/create/{platformId}', [ApplicationController::class, 'create'])->name('applications.create');
Route::post('/applications', [ApplicationController::class, 'store'])->name('applications.store');

// Админка
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'login'])->name('admin.login');
    
    Route::middleware('admin.password')->group(function () {
        Route::get('/dashboard/{password?}', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/platforms/create/{password?}', [PlatformController::class, 'create'])->name('admin.platforms.create');
        Route::post('/platforms/{password?}', [PlatformController::class, 'store'])->name('admin.platforms.store');
        Route::get('/participants/export/{password?}', [AdminController::class, 'export'])->name('admin.participants.export');
        Route::get('/participants/{password?}', [AdminController::class, 'participants'])->name('admin.participants');
        Route::get('/platforms/{id}/{password?}', [AdminController::class, 'platformShow'])->name('admin.platforms.show');
        Route::get('/platforms/{password?}', [AdminController::class, 'platformsIndex'])->name('admin.platforms.index');
    });
});

require __DIR__.'/auth.php';
