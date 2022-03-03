<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class BuiltCVByAdminModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'built_cv_admin';
    protected $primaryKey   = 'builtcvID';


    protected $fillable = [
        'userID',
        'file_description',
        'file_name',
        'created_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
