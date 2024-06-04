<?php


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use Coderflex\LaravelTicket\Models\Category;


Route::get('/', function () {
    return view('welcome')->name('home');
});
Route::middleware('auth')->group(function () {
    
    Route::get('/create', [ArticleController::class, 'create'])->name('admin.article.create');
});

Route::get('/agent', function () {
    return view('agent.index');
});

Route::get('/dashboard', function () {
    if (auth()->user->roles == 'admin') {
        redirect('admin.article.create');
    }
    else {
        redirect('home');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
