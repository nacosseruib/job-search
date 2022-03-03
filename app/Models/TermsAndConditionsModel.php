<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class TermsAndConditionsModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'terms_conditions';
    protected $primaryKey   = 'terms_conditionsID';


    protected $fillable = [
        'title',
        'content',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
