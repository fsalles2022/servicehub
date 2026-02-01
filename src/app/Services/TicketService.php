<?php

namespace App\Services;

use App\Repositories\TicketRepository;
use App\Models\TicketDetail;

class TicketService
{
    protected $repository;

    public function __construct(TicketRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createTicket(array $data)
    {
        $data['user_id'] = 1; // temporário, depois use auth()->id()
        $data['status'] = 'open';

        // Cria o ticket
        $ticket = $this->repository->create($data);

        // Cria o detalhe técnico
        TicketDetail::create([
            'ticket_id' => $ticket->id,
            'description' => $data['description'] ?? null,
        ]);

        return $ticket->load('detail', 'project', 'user');
    }

    public function index()
    {
        return $this->repository->all();
    }
}
