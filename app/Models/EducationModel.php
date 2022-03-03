<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class EducationModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'education';
    protected $primaryKey   = 'educationID';


    protected $fillable = [
        'userID',
        'certificate_titleID',
        'course_title',
        'date_started',
        'date_completed',
        'institution',
        'grade_id',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
