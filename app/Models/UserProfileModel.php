<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class UserProfileModel extends Model
{
    use HasFactory, Notifiable;

    protected $table        = 'user_profile';
    protected $primaryKey   = 'user_profileID';


    protected $fillable = [
        'userID',
        'first_name',
        'last_name',
        'gender',
        'day_of_birth',
        'month_of_birth',
        'year_of_birth',
        'country',
        'location_city',
        'country_code',
        'phone_number',
        'address',
        //'type_of_employer', //Moved to user modela as user_type
        'contact_name',
        'about_company',
        'contact_email',
        'company_name',
        'company_industry_id',
        'number_of_employee',
        'company_website',
        'profile_picture',
        'profile_banner',
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'created_at',
        'updated_at',
        'updated_at_time',
        'status',
    ];



    protected $casts = [];

    protected $hidden = [];

    public $timestamps = false;

}
