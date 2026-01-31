<?php

// database/seeders/TicketSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ticket;
use App\Models\TicketDetail;
use App\Models\Project;
use App\Models\User;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        foreach (Project::all() as $project) {
            foreach ($users as $user) {
                $ticket = Ticket::create([
                    'project_id' => $project->id,
                    'user_id' => $user->id,
                    'title' => 'Ticket de teste para ' . $project->name,
                    'status' => 'open'
                ]);

                TicketDetail::create([
                    'ticket_id' => $ticket->id,
                    'description' => 'Detalhes técnicos do ticket para ' . $project->name,
                    'technical_notes' => 'Observações técnicas do ticket'
                ]);
            }
        }
    }
}
