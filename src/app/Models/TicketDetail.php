<?php

// app/Models/TicketDetail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketDetail extends Model
{
    use HasFactory;

    protected $fillable = ['ticket_id', 'description', 'technical_notes'];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
