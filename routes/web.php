<?php

use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\AgentTicketController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserTicketController;
use Coderflex\LaravelTicket\Models\Category;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return view('user.index');
})->name('home');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/articles', ArticleController::class)->names('admin.article');
    
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware(['auth','role:agent'])->group(function () {
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');

    
});

Route::middleware('auth')->group(function () {
    Route::resource('/user/ticket', UserTicketController::class)->names('user.ticket');
    Route::resource('/agent/ticket', AgentTicketController::class)->names('agent.ticket');

});

Route::get('/dashboard', function () {
    if (Auth::user()->roles->pluck('name')[0] == 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    else if (Auth::user()->roles->pluck('name')[0] == 'agent') {
        return redirect()->route('agent.index');
    } 
    else if (Auth::user()->roles->pluck('name')[0] == 'user') {
        return redirect()->route('user.ticket');
    } 
    else {
        return redirect('home');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';