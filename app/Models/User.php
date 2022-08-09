<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','isAdmin','photoProfil','prenom'
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

    public function profils()
    {
        return $this->hasMany('App\Models\Profil');
    }

    public function profilsSuivre()
    {
        return $this->belongsToMany('App\Models\Profil', 'user_profil','user_suivre_id','profil_suivre_id');
    }

    public function commentaires()
    {
        return $this->hasMany('App\Models\Commentaire');
    }

}
