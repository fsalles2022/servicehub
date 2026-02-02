<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TicketDetail;

class TicketDetailFactory extends Factory
{
    protected $model = TicketDetail::class;

    public function definition()
    {
        return [
            'ticket_id' => \App\Models\Ticket::factory(),
            'description' => $this->faker->paragraph,
        ];
    }
}
