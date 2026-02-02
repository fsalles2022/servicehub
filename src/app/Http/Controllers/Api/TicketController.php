<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Services\TicketService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTicketRequest;
use App\Jobs\ProcessTicketAttachment;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request, TicketService $service)
    {
        $ticket = $service->createTicket($request->validated());

        return response()->json([
            'data' => $ticket
        ], 201);
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['detail', 'project', 'user']);

        return response()->json([
            'data' => $ticket
        ]);
    }
public function upload(Request $request, Ticket $ticket)
{
    $request->validate([
        'attachment' => 'required|file|mimes:json,txt'
    ]);

    $path = $request->file('attachment')->store("tickets/{$ticket->id}", 'local');

    ProcessTicketAttachment::dispatch($ticket, $path);

    return response()->json([
        'data' => ['queued' => true]
    ]);
}

    public function download(Ticket $ticket)
    {
        $content = $ticket->detail?->technical_notes;

        if (! $content) {
            return response()->json([
                'error' => 'Arquivo não encontrado'
            ], 404);
        }

        return response($content)
            ->header('Content-Type', 'text/plain; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="ticket_' . $ticket->id . '.txt"');
    }

    public function index(TicketService $service)
    {
        $tickets = $service->index();

        return response()->json([
            'data' => $tickets
        ]);
    }
}
