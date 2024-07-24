<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('channel_for_everyone', function ($user) {
    return true;
});
Broadcast::channel('messages.{ticketId}', function ($user, $ticketId) {
    return ['id' => $user->id, 'name' => $user->name]; // Return user info
});
