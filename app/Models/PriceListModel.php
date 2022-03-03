<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class PriceListModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'price_list';
    protected $primaryKey   = 'priceID';


    protected $fillable = [
        'price_description',
        'price_amount',
        'price_duration',
        'details',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
