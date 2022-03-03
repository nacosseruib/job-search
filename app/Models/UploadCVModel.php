<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class UploadCVModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'candidate_cv';
    protected $primaryKey   = 'candidate_cvID';


    protected $fillable = [
        'userID',
        'file_description',
        'file_name',
        'status',
        'created_at',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
