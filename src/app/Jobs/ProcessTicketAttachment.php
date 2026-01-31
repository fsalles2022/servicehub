<?php

namespace App\Jobs;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $ticketId,
        public string $path
    ) {}

    public function handle(): void
    {
        $ticket = Ticket::with('detail')->findOrFail($this->ticketId);

        $content = file_get_contents(storage_path("app/{$this->path}"));

        $data = json_decode($content, true) ?? ['raw' => $content];

        $ticket->detail()->updateOrCreate(
            ['ticket_id' => $ticket->id],
            ['payload' => $data]
        );
    }
}
