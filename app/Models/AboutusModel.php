<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class AboutusModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'about_us';
    protected $primaryKey   = 'aboutusID';


    protected $fillable = [
        'title',
        'content',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
