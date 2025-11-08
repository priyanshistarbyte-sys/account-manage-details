<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
       'name',
       'email',
       'password',
       'register_mobile_no',
       'register_email',
       'authenticator_code',
       'location',
       'icon',
       'banner',
       'created_by'
    ];


    
}
