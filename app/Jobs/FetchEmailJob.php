<?php

namespace App\Jobs;

use App\Http\Controllers\MailController;
use App\Http\Controllers\UserTicketController;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
         // Fetch credentials from environment variables
         $hostname = env('IMAP_HOSTNAME', '{imap.hostinger.com:993/imap/ssl}INBOX');
         $username = env('IMAP_USERNAME', 'earthqualizer@radenbambangsyumanjaya.com');
         $password = env('IMAP_PASSWORD', 'Earthqualizer123!');
 
         // Try to connect to the IMAP server
         $inbox = imap_open($hostname, $username, $password) or die('Cannot connect to Mail: ' . imap_last_error());
 
         // Fetch emails
         $emails = imap_search($inbox, 'UNSEEN'); // Fetch only unread emails
 
         if ($emails) {
             foreach ($emails as $email_number) {
                 $overview = imap_fetch_overview($inbox, $email_number, 0);
                 $message = imap_fetchbody($inbox, $email_number, 1);
 
                 $senderEmail = $overview[0]->from;
                 $senderEmail = filter_var(trim(explode('<', $overview[0]->from)[1], '>'), FILTER_SANITIZE_EMAIL);
 
                 $user = \App\Models\User::where('email', $senderEmail)->first();
 
                 // Check if the sender exists in the users database
                 if ($user) {
                     // Create a ticket from the email using UserTicketController
                     $ticketController = new UserTicketController();
                     $ticketController->storeFromEmail($user->id, $overview[0]->subject, $message); // Assuming this method exists in UserTicketController
 
                     Log::info('Ticket created for email from: ' . $senderEmail);
                 } else {
                     Log::info('Sender not found in database: ' . $senderEmail);
                 }
             }
         } else {
             Log::info('No unread emails found.');
         }
 
         // Close the connection
         imap_close($inbox);
    }
}