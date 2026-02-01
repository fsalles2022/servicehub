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

        Log::info("📢 Ticket {$ticket->id} processado para {$ticket->user->email}");
    }
}
