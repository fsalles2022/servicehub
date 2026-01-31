<?php
// app/Services/TicketService.php
namespace App\Services;

use App\Repositories\TicketRepository;
use App\Models\TicketDetail;

class TicketService
{
    public function __construct(
        protected TicketRepository $repository
    ) {}

    public function createTicket(array $data)
{
    $data['user_id'] = 1; // temporário
    $data['status'] = 'open';

    $ticket = $this->repository->create($data);

    TicketDetail::create([
        'ticket_id' => $ticket->id,
        'description' => $data['description'] ?? null,
    ]);

    return $ticket;
}

}
