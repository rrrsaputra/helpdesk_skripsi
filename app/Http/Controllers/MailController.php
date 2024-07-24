<?php

namespace App\Http\Controllers;



use App\Mail\SendMail;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserTicketController; // Import UserTicketController



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
        

        $hostname = '{imap.hostinger.com:993/imap/ssl}INBOX'; // Replace with your IMAP server
        $username = 'earthqualizer@radenbambangsyumanjaya.com'; // Replace with your email
        $password = 'Earthqualizer123!'; // Replace with your password

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