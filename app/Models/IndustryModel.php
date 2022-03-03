<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class IndustryModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'industry';
    protected $primaryKey   = 'industryID';


    protected $fillable = [
        'industry_name',
        'status',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
