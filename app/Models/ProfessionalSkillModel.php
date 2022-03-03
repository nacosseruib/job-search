<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ProfessionalSkillModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'professional_skill';
    protected $primaryKey   = 'skillID';


    protected $fillable = [
        'userID',
        'skill_title',
        'efficiency',
        'year_of_experience',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
