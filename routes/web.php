<?php

use App\Models\Feedback;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\AgentController;
use Coderflex\LaravelTicket\Models\Label;
use Coderflex\LaravelTicket\Models\Ticket;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TriggerController;
use App\Http\Controllers\DropzoneController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\UserHomeController;
use Coderflex\LaravelTicket\Models\Category;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\UserTicketController;
use App\Http\Controllers\AdminTicketController;
use App\Http\Controllers\AgentTicketController;
use App\Http\Controllers\UserArticleController;
use Spatie\Permission\Middleware\RoleMiddleware;
use App\Http\Controllers\AdminFeedbackController;
use App\Http\Controllers\AdminTriggersController;
use App\Http\Controllers\AgentMessagesController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AgentDashboardController;
use App\Http\Controllers\UserSuperSearchController;
use App\Http\Controllers\UserTicketQuotaController;
use App\Http\Controllers\AdminBusinessHourController;
use App\Http\Controllers\UserScheduledCallController;
use App\Http\Controllers\AdminScheduledCallController;
use App\Http\Controllers\AgentScheduledCallController;
use App\Http\Controllers\AdminDataRepositoryController;
use App\Http\Controllers\AdminTicketCategoryController;
use App\Http\Controllers\AdminUserManagementController;
use App\Http\Controllers\UserArticleCategoryController;
use App\Http\Controllers\AdminArticleCategoryController;
use App\Http\Controllers\AdminScheduledCallCategoryController;
use App\Http\Controllers\MailController;

Route::get('send-email',[MailController::class, 'sendEmail']);
Route::get('get-email',[MailController::class, 'getMail']);

Route::middleware('auth')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    // Route::get('/category/{slug}', [HomeController::class, 'show'])->name('category.show');

    // Route::get('/trigger', [TriggerController::class, 'index'])->name('trigger');
    Route::post('/messages/{id}', [AgentMessagesController::class, 'store'])->name('agent.messages.store');
    Route::get('/messages', [HomeController::class, 'messages'])
        ->name('messages');




    Route::post('/dropzone/upload', [DropzoneController::class, 'upload'])->name('dropzone.upload');
    Route::post('/dropzone/remove', [DropzoneController::class, 'remove'])->name('dropzone.remove');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/uploads/process', [FileUploadController::class, 'process'])->name('uploads.process');
    Route::delete('/uploads/revert', [FileUploadController::class, 'revert'])->name('uploads.revert');
});

// Route::get('/single-article', function () {
//     return view('user.articles.single-article');
// })->name('single-article');



Route::middleware(['auth', 'role:user'])->group(function () {
    
        
        Route::resource('/feedback', FeedbackController::class)->names('user.feedback');
        Route::resource('/tickets', UserTicketController::class)->names('tickets');
        Route::resource('/scheduled-calls', UserScheduledCallController::class)->names('scheduled_call');
        Route::resource('/article', UserArticleController::class)->names('article');
        Route::get('/category/{slug}', [UserArticleCategoryController::class, 'show'])->name('category.show');
        Route::resource('/user/ticket', UserTicketController::class)->names('user.ticket');
        Route::resource('/user/scheduled-ticket', UserScheduledCallController::class)->names('user.scheduled-ticket');
        
    
        // Route::get('/user/scheduled_calls/{id}', [UserScheduledCallController::class, 'show'])->name('user.scheduled_calls.single-scheduled-call');

    // Route::get('/ticket-submit', function () {
    //     return view('user.tickets.ticket-submit');
    // })->name('ticket-submit');

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
    Route::resource('admin/scheduled-call-category', AdminScheduledCallCategoryController::class)->names('admin.scheduled_call_category');
    Route::get('admin/scheduled-call-category/{id}/show_visible', [AdminScheduledCallCategoryController::class, 'show_visible'])->name('admin.scheduled_call_category.show_visible');
    Route::get('admin/scheduled-call-category/{id}/hide_visible', [AdminScheduledCallCategoryController::class, 'hide_visible'])->name('admin.scheduled_call_category.hide_visible');
    Route::patch('/admin/scheduled-call/reject/{id}', [AdminScheduledCallController::class, 'reject'])->name('admin.scheduled_call.reject');
    Route::get('/admin/scheduled-call/get_time/{id}', [AdminScheduledCallController::class, 'get_time'])->name('admin.scheduled_call.get_time');

    Route::resource('/admin/business-hour', AdminBusinessHourController::class)->names('admin.business_hour');
    Route::resource('/admin/ticket_quota', UserTicketQuotaController::class)->names('admin.ticket_quota');

    Route::resource('/admin/article-category', AdminArticleCategoryController::class)->names('admin.article_category');

    Route::resource('/admin/feedback', AdminFeedbackController::class)->names('admin.feedback');

    Route::resource('/admin/ticket-category', AdminTicketCategoryController::class)->names('admin.ticket_category');
    Route::get('admin/ticket_category/{id}/show_visible', [AdminTicketCategoryController::class, 'show_visible'])->name('admin.ticket_category.show_visible');
    Route::get('admin/ticket_category/{id}/hide_visible', [AdminTicketCategoryController::class, 'hide_visible'])->name('admin.ticket_category.hide_visible');

    Route::resource('/admin/ticket', AdminTicketController::class)->names('admin.ticket');

    Route::resource('/admin/triggers', AdminTriggersController::class)->names('admin.triggers');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard.index');
    Route::get('admin/dashboard/user/{id}', [AdminDashboardController::class, 'getUserData']);

    Route::resource('/admin/data-repository', AdminDataRepositoryController::class)->names('admin.data_repository');

    Route::patch('/admin/ticket/unassign/{ticket}', [AdminTicketController::class, 'unassign'])->name('admin.ticket.unassign');
    Route::patch('/admin/ticket/close/{ticket}', [AdminTicketController::class, 'close'])->name('admin.ticket.close');
    Route::patch('/admin/ticket/reopen/{ticket}', [AdminTicketController::class, 'reopen_ticket'])->name('admin.ticket.reopen_ticket');

    Route::resource('/admin/user-management', AdminUserManagementController::class)->names('admin.user_management');
});

Route::middleware('auth', 'role:agent')->group(function () {

    Route::resource('/messages', AgentMessagesController::class)->only(['index', 'create', 'show', 'edit', 'update', 'destroy'])->names('agent.messages');
    
    Route::get('/agent', [AgentController::class, 'index'])->name('agent.index');
    Route::get('/notifications/read/{id}', [AgentController::class, 'markAsRead'])->name('notifications.read');

    Route::resource('/agent/schedule-call', AgentScheduledCallController::class)->names('agent.scheduled_call');

    Route::get('/agent/dashboard', [AgentDashboardController::class, 'index'])->name('agent.dashboard.index');
    Route::get('agent/dashboard/user/{id}', [AgentDashboardController::class, 'getUserData']);

    Route::resource('/agent/ticket', AgentTicketController::class)->names('agent.ticket');
    Route::patch('/agent/ticket/get/{ticket}', [AgentTicketController::class, 'get'])->name('agent.ticket.get');
    Route::patch('/agent/ticket/unassign/{ticket}', [AgentTicketController::class, 'unassign'])->name('agent.ticket.unassign');
    Route::patch('/agent/ticket/close/{ticket}', [AgentTicketController::class, 'close'])->name('agent.ticket.close');
    Route::patch('/agent/ticket/reopen/{ticket}', [AgentTicketController::class, 'reopen_ticket'])->name('agent.ticket.reopen_ticket');
});


Route::get('/dashboard', function () {
    $role = Auth::check() ? Auth::user()->roles->pluck('name')->first() ?? 'guest' : 'guest';

    if ($role == 'admin') {
        return redirect()->route('admin.dashboard.index');
    } else if ($role == 'agent') {
        return redirect()->route('agent.dashboard.index');
    } else if ($role == 'user') {
        return redirect()->route('home');
    } else {
        return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');





require __DIR__ . '/auth.php';
