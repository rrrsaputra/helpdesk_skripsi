<?php
   namespace App\Events;

   use Illuminate\Broadcasting\Channel;
   use Illuminate\Broadcasting\InteractsWithSockets;
   use Illuminate\Broadcasting\PresenceChannel;
   use Illuminate\Broadcasting\PrivateChannel;
   use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
   use Illuminate\Foundation\Events\Dispatchable;
   use Illuminate\Queue\SerializesModels;
   use App\Models\Message;
use App\Models\User;
use Coderflex\LaravelTicket\Models\Message as ModelsMessage;

   class MessageSent implements ShouldBroadcast
   {
       use Dispatchable, InteractsWithSockets, SerializesModels;

       public $message,$user;

       public function __construct(ModelsMessage $message, User $user)
       {    
           $this->message = $message;
           $this->user = $user;

       }

       public function broadcastOn()
       {

           // Ensure the ticket relationship is loaded and accessible
        if ($this->message->ticket) {
            return new PrivateChannel('messages.' . $this->message->ticket->id);
        }

        // Handle the case where the ticket relationship is not available
        return new PrivateChannel('messages.unknown');
       }
       public function broadcastWith()
{
    return [
        'message' => $this->message,
        'user' => $this->user,
        'attachments' => $this->message->attachments->map(function ($attachment) {
            return [
                'path' => asset('storage/' . $attachment->path),
                'name' => $attachment->name,
            ];
        }),
    ];
}
   }