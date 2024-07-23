<?php

namespace App\Jobs;

use App\Mail\SendMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $ticket;
    protected $userEmail;
    /**
     * Create a new job instance.
     */
    public function __construct($tic, $userEmail)
    {
        $this->ticket = $tic;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $title = "You have made a Ticket";
        $message = "Your scheduled call titled '{$this->ticket->title}' has been successfully created.";
        Mail::to($this->userEmail)->send(new SendMail($title, $message));
    }
}
