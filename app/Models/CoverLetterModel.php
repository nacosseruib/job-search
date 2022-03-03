<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CoverLetterModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'user_cover_letter';
    protected $primaryKey   = 'user_cover_letterID';


    protected $fillable = [
        'userID',
        'cover_letter',
        'status',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
