<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'aisle',
        'quantity_store',
        'quantity_storage',
        'price',
        'SKU',
    ];

    protected $casts = [
        'quantity_store' => 'integer',
        'quantity_storage' => 'integer',
        'price' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}