<?php

// app/Listeners/SendTicketProcessedNotification.php
namespace App\Listeners;

use App\Events\TicketProcessed;
use Illuminate\Support\Facades\Log;

class SendTicketProcessedNotification
{
    public function handle(TicketProcessed $event)
    {
        $ticket = $event->ticket;

        if (! $ticket->relationLoaded('user')) {
            $ticket->load('user.profile');
        }

        $profile = $ticket->user?->profile;

        Log::info("📢 Ticket {$ticket->id} processado para {$ticket->user->email}");

        if ($profile) {
            Log::info("📢 {$profile->role} ({$profile->phone}) recebeu ticket {$ticket->id}");
        }
    }
}

