<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Eloquent\Model;

class User extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'users';
}
