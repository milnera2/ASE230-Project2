<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'role',
        'join_date',
        'dues_paid',
        'active',
        'events_attended',
    ];

    protected $casts = [
        'join_date' => 'date',
        'dues_paid' => 'boolean',
        'active' => 'boolean',
        'events_attended' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}