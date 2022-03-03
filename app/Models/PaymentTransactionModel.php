<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class PaymentTransactionModel extends Model
{
    use HasFactory, Notifiable;

     //Using UUID
     use Uuid;
     protected $keyType      = 'string';
     public $incrementing    = false;
     protected $guarded      = [];

    protected $table        = 'payment_transaction';
    protected $primaryKey   = 'paymentID';


    protected $fillable = [
        'userID',
        'transactionID',
        'payment_type',
        'payment_amount',
        'payment_description',
        'wallet_balance',
        'created_at',
        'created_at_time',
        'ip_address',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
