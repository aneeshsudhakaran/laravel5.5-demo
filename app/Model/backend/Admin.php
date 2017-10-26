<?php

namespace App\Model\backend;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\AdminResetPasswordNotification;

 
class Admin extends Authenticatable
{
    use Notifiable;
    
    protected $guard = 'admin';
 
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
            return Admin::create([
                    'name' => $input['name'],
                    'email' => $input['email'],
                    'password' => bcrypt($input['password']),
                ]);
    }
    
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }
    
}
