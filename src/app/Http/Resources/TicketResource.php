<?php

// app/Http/Resources/TicketResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'project' => $this->project->name,
            'company' => $this->project->company->name,
            'user' => optional($this->user)->name,
            'detail' => $this->ticketDetail->description,
        ];
    }
}
