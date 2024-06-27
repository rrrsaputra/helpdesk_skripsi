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
use Coderflex\LaravelTicket\Models\Message as ModelsMessage;

   class MessageSent implements ShouldBroadcast
   {
       use Dispatchable, InteractsWithSockets, SerializesModels;

       public $message;

       public function __construct(ModelsMessage $message)
       {
           $this->message = $message;
       }

       public function broadcastOn()
       {
           return new PrivateChannel('messages.' . $this->message->ticket_id);
       }
   }