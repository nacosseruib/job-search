<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PaymentSetUpModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'payment_setup';
    protected $primaryKey   = 'payment_setupID';


    protected $fillable = [
        'email',
        'currency',
        'full_name',
        'gateway_name',
        'gateway_url',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
