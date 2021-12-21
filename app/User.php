<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;
    protected static $logAttributes = ['name','email'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_code', 
        'email',
        'phone',
        'address',
        'password',
        'user_type',
        'user_type_id',
        'type_id',
        'date_of_join',
        'is_active',
        'date',
        'date_np',
        'time',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function usertype(){
        return $this->belongsTo(Usertype::class,'user_type_id');
    }

    public  function userpackage(){
        return $this->belongsToMany('App\Canteen_package','user_has_packages','user_id','canteen_package_id');
    }

    public function getPack()
    {
        return $this->belongsTo(User_has_package::class,'id','user_id');
    }

    public function getSalary()
    {
        return $this->belongsTo(User_has_salary::class,'id','user_id');
    }

    public function getSalaryUser(){
        return $this->belongsTo(Usertype::class,'user_type_id');
    }
}
