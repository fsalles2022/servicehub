<?php

// app/Http/Controllers/Api/TicketController.php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\TicketService;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;

class TicketController extends Controller
{
    public function __construct(
        protected TicketService $service
    ) {}

    public function store(StoreTicketRequest $request)
    {
        $ticket = $this->service->createTicket($request->validated());

        return new TicketResource($ticket);
    }

    public function show(int $id)
    {
        $ticket = app(\App\Repositories\TicketRepository::class)
            ->findWithRelations($id);

        return new TicketResource($ticket);
    }
}
