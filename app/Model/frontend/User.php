<?php

namespace App\Model\frontend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\UserResetPasswordNotification;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public static function registeruser($input = array()) {
            return User::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => bcrypt($input['password']),
                ]);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPasswordNotification($token));
    }
    
}
