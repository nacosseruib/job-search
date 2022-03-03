<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class CertificateModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'certificate';
    protected $primaryKey   = 'certificateID';


    protected $fillable = [
        'certificate_name',
        'status',
        'updated_at',
    ];


    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
