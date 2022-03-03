<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class WorkExperienceModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'work_experience';
    protected $primaryKey   = 'work_experienceID';


    protected $fillable = [
        'userID',
        'job_title',
        'company_name',
        'date_started',
        'date_stop',
        'job_description',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
