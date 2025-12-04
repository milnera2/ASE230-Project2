<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'address',
        'is_delivered',
        'last_location',
        'current_location',
        'tracking_sku',
    ];

    protected $casts = [
        'is_delivered' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}