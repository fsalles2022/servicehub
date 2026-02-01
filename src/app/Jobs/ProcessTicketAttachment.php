<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ProcessTicketAttachment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ticket $ticket;
    public string $path;

    public function __construct(Ticket $ticket, string $path)
    {
        $this->ticket = $ticket;  //Tem queser o modelo
        $this->path = $path;
    }

    public function handle()
    {
        // Lê o arquivo
        $content = Storage::get($this->path);

        //*Atualiza o TicketDetail relacionado
        // $this->ticket->detail()->update([
        //    'technical_notes' => $content,
        // ]);
        //Atualiza ou cria o TicketDetail relacionado
        TicketDetail::updateOrCreate(
            ['ticket_id' => $this->ticket->id],
            ['technical_notes' => $content]
        );


        // Você pode adicionar notificações aqui se quiser
    }
}
