<?php

namespace App\Models;

use App\Events\PhotoEventCreated;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $table = 'photos';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'image', 'valider', 'profil_id', 'nom', 'email', 'commentaires', 'dateDuPhoto', 'nomDesGens','jaime'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    public function commentaires()
    {
        return $this->hasMany('App\Models\Commentaire');
    }

    protected $dispatchesEvents = [
        'created' => PhotoEventCreated::class,
    ];
}
