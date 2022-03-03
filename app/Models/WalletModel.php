<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class WalletModel extends Model
{
    use HasFactory, Notifiable;

     //Using UUID
     use Uuid;
     protected $keyType      = 'string';
     public $incrementing    = false;
     protected $guarded      = [];

    protected $table        = 'wallet';
    protected $primaryKey   = 'walletID';


    protected $fillable = [
        'userID',
        'balance_amount',
        'booked_amount',
        'created_at',
        'updated_at',
        'updated_at_time',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
