<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

Broadcast::routes();
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Your channel definitions
Broadcast::channel('notifications', function ($user) {
     Log::info('Authorizing private channel', ['user_id' => $user->id]);
    return true; // Allow anyone authenticated to listen
});
