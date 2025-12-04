<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'time_start',
        'time_end',
        'num_guests',
        'is_purchased',
    ];

    protected $casts = [
        'time_start' => 'datetime',
        'time_end' => 'datetime',
        'num_guests' => 'integer',
        'is_purchased' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}