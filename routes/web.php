<?php

use App\Models\Feedback;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\AgentController;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserHomeController;
use Coderflex\LaravelTicket\Models\Category;
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AgentTicketController;
use App\Http\Controllers\UserArticleController;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminBusinessHourController;
use App\Http\Controllers\UserScheduledCallController;
use App\Http\Controllers\AdminScheduledCallController;
use App\Http\Controllers\AgentMessagesController;
use App\Http\Controllers\AgentScheduledCallController;
use App\Http\Controllers\HomeController;



Route::get('/', [HomeController::class, 'index'])
    ->name('home');
    
Route::get('/messages', [HomeController::class, 'messages'])
    ->name('messages');



Route::resource('/article', UserArticleController::class)->names('article');

// Route::get('/single-article', function () {
//     return view('user.articles.single-article');
// })->name('single-article');



Route::middleware(['auth', 'role:user'])->group(function () {
    Route::resource('/feedback', FeedbackController::class)->names('user.feedback');
    Route::resource('/tickets', UserTicketController::class)->names('tickets');
    Route::resource('/scheduled-calls', UserScheduledCallController::class)->names('scheduled_call');


    // Route::get('/user/scheduled_calls/{id}', [UserScheduledCallController::class, 'show'])->name('user.scheduled_calls.single-scheduled-call');
    
    Route::get('/ticket-submit', function () {
        return view('user.tickets.ticket-submit');
    })->name('ticket-submit');

    // Route::get('/scheduled-call', function () {
    //     return view('user.scheduled_calls.scheduled_call');
    // })->name('scheduled_call');

    Route::get('/scheduled-call-submit', function () {
        return view('user.scheduled_calls.scheduled_call_submit');
    })->name('scheduled_call_submit');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('/admin/articles', ArticleController::class)->names('admin.article');
    
    Route::resource('/admin/scheduled-call', AdminScheduledCallController::class)->names('admin.scheduled_call');
    Route::resource('/admin/business-hour', AdminBusinessHourController::class)->names('admin.business_hour');
    
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware('auth','role:agent')->group(function () {
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');
    Route::resource('/agent/schedule-call', AgentScheduledCallController::class)->names('agent.scheduled_call');

});

Route::middleware('auth')->group(function () {
    Route::resource('/messages', AgentMessagesController::class)->only(['index', 'create', 'show', 'edit', 'update', 'destroy'])->names('agent.messages');
    Route::post('/messages/{id}', [AgentMessagesController::class, 'store'])->name('agent.messages.store');
    Route::resource('/user/ticket', UserTicketController::class)->names('user.ticket');
    Route::resource('/user/scheduled-ticket', UserScheduledCallController::class)->names('user.scheduled-ticket');
    Route::resource('/agent/ticket', AgentTicketController::class)->names('agent.ticket');
    Route::patch('/agent/ticket/get/{ticket}', [AgentTicketController::class, 'get'])->name('agent.ticket.get');
    Route::patch('/agent/ticket/unassign/{ticket}', [AgentTicketController::class, 'unassign'])->name('agent.ticket.unassign');
    Route::patch('/agent/ticket/close/{ticket}', [AgentTicketController::class, 'close'])->name('agent.ticket.close');
    Route::patch('/agent/ticket/reopen/{ticket}', [AgentTicketController::class, 'reopen_ticket'])->name('agent.ticket.reopen_ticket');

});

Route::get('/dashboard', function () {
    if (Auth::user()->roles->pluck('name')[0] == 'admin') {
        return redirect()->route('admin.dashboard');
    } 
    else if (Auth::user()->roles->pluck('name')[0] == 'agent') {
        return redirect()->route('agent.index');
    } 
    else if (Auth::user()->roles->pluck('name')[0] == 'user') {
        return redirect()->route('home');
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