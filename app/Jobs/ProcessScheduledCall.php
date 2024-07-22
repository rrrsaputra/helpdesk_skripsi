<?php

namespace App\Jobs;

use App\Mail\SendMail;
use App\Models\Attachment_Call;
use App\Models\ScheduledCall;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessScheduledCall implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $scheduledCall;
    protected $filepondData;
    protected $userEmail;

    /**
     * Create a new job instance.
     */
    public function __construct($scheduledCall, $userEmail)
    {
        $this->scheduledCall = $scheduledCall;
        $this->userEmail = $userEmail;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $title = "You have made a scheduled call";
        $message = "Your scheduled call titled '{$this->scheduledCall->title}' has been successfully created for " . date('Y-m-d H:i:s', strtotime($this->scheduledCall->start_time)) . ".";
        Mail::to($this->userEmail)->send(new SendMail($title, $message));
    }
}