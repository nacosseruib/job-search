<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class PaymentHistoryModel extends Model
{
    use HasFactory, Notifiable;

     //Using UUID
     use Uuid;
     protected $keyType      = 'string';
     public $incrementing    = false;
     protected $guarded      = [];

    protected $table        = 'payment_history';
    protected $primaryKey   = 'paymentID';


    protected $fillable = [
        'userID',
        'transactionID',
        'paymentForID',
        'amount',
        'amount_paid',
        'payment_description',
        'payment_status_code',
        'payment_success',
        'payment_reference',
        'created_at',
        'updated_at',
        'updated_at_time',
        'status',
        'payment_json_data',
        'is_hidden',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
