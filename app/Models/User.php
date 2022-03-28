<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'name_en',
        'email',
        'password',
        'image',
        'location',
        'role',
        'discription',
        'discription_en',
        'gender',
        'status',
        'total',
        'phone',
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
    public function wasfas()
    {
        return $this->hasMany(Wasfa::class);
    }
    public function categories()
    {
        return $this->hasMany(Category::class);
    }
    public function banks()
    {
        return $this->hasMany(Bank::class);
    }
    public function adds()
    {
        return $this->hasMany(Adds::class);
    }
    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
    public function income()
    {
        return $this->hasMany(Income::class);
    }
    public function name()
    {
        if (App::getLocale() == 'ar') {
            return $this->name;
        } else {
            return $this->name_en;
        }
    }
}
