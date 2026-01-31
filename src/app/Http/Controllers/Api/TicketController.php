<?php

// app/Http/Controllers/Api/TicketController.php
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
        return response()->json(
            $service->createTicket($request->validated()),
            201
        );
    }

    public function show(Ticket $ticket)
    {
        return $ticket->load(['detail', 'project', 'user']);
    }

    public function upload(Request $request, Ticket $ticket)
    {
        $request->validate([
            'attachment' => 'required|file|mimes:json,txt'
        ]);

        $path = $request->file('attachment')->store('tickets');

        ProcessTicketAttachment::dispatch($ticket->id, $path);

        return response()->json(['queued' => true]);
    }
}
