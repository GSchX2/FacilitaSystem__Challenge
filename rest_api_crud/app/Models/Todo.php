<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    /* Limita o preenchimento da base de dados
    pelo usário aos campos definidos abaixo */
    protected $fillable = [
        'title', 
        'description',
        'done', 
        'due_date'
    ];
}
