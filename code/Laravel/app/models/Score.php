<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_name',
        'class_name',
        'assignment_score',
        'assignment_letter_grade',
        'class_score',
        'class_letter_grade',
    ];

    protected $casts = [
        'assignment_score' => 'integer',
        'class_score' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}