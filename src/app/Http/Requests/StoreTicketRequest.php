<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
    public function rules()
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string',
            'description' => 'required|string',
        ];
    }
}
