<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class BuildCVRequestModel extends Model
{
    use HasFactory, Notifiable;

     //Using UUID
     use Uuid;
     protected $keyType      = 'string';
     public $incrementing    = false;
     protected $guarded      = [];

    protected $table        = 'buildcv_request';
    protected $primaryKey   = 'buildcvID';

    protected $fillable = [
        'userID',
        'cvID',
        'description',
        'resume_details',
        'transactionID',
        'created_at',
        'updated_at',
        'updated_at_time',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
