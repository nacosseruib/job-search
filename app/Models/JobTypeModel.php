<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class JobTypeModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'job_type';
    protected $primaryKey   = 'job_typeID';


    protected $fillable = [
        'type_name',
        'status',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
