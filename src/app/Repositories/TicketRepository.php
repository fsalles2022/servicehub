<?php

namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    public function create(array $data): Ticket
    {
        //dd($data);

        return Ticket::create($data);
    }

    public function findWithRelations(int $id): Ticket
    {
        return Ticket::with(['ticketDetail', 'project.company', 'user.userProfile'])
            ->findOrFail($id);
    }

    public function all()
    {
        return Ticket::all();
    }
}
