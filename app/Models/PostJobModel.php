<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;

class PostJobModel extends Model
{
    use HasFactory, Notifiable;

     //Using UUID
     use Uuid;
     protected $keyType      = 'string';
     public $incrementing    = false;
     protected $guarded      = [];

    protected $table        = 'job_posted';
    protected $primaryKey   = 'jobID';


    protected $fillable = [
        'userID',
        'job_token',
        'job_status',
        'job_category',
        'job_location',
        'job_cover_img',
        'job_title',
        'job_type',
        'job_post_date',
        'job_expire_date',
        'job_description',
        'job_requirement',
        'job_education_experience',
        'job_about_company',
        'job_contact_phone',
        'job_contact_name',
        'job_country',
        'job_apply_email',
        'job_company_name',
        'job_salary',
        'created_at',
        'updated_at',
        'updated_at_time',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
