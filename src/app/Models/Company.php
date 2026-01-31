<?php

// app/Models/Company.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone'];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
