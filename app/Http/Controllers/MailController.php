<?php

namespace App\Http\Controllers;



use App\Mail\SendMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserTicketController; // Import UserTicketController
use App\Jobs\FetchEmailJob;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        try {
            $toEmailAddress = "earthqualizer@radenbambangsyumanjaya.com";
            $title = $request->title;
            $message = $request->message;
            $response = Mail::to($toEmailAddress)->send(new SendMail($title, $message));
            dd($response);

            // Log success message
            Log::info('Mail sent successfully to ' . $toEmailAddress);
        } catch (Exception $e) {
            Log::error('Mail sending failed: ' . $e->getMessage());
        }
    }



    public function getMail()
    {
        FetchEmailJob::dispatch();
        return redirect()->route('admin.ticket.index', ['inbox' => 'unassigned'])->with('success', 'Email fetching job dispatched.');
    }
}
