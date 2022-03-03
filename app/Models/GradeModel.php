<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class GradeModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'grade';
    protected $primaryKey   = 'gradeID';


    protected $fillable = [
        'grade_name',
        'status',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
