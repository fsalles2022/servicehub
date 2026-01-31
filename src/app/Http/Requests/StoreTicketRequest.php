<?php

namespace App\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends FormRequest
{
public function rules()
{
    return [
        'title' => 'required|string',
        'description' => 'required|string',
        'status_id' => 'required|exists:statuses,id',
        'priority_id' => 'required|exists:priorities,id',
        'user_id' => 'required|exists:users,id',
    ];
}

}
