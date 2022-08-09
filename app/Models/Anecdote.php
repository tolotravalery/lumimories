<?php

namespace App\Models;

use App\Events\AnecdoteEventCreated;
use Illuminate\Database\Eloquent\Model;

class Anecdote extends Model
{
    protected $table = 'anecdotes';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'avis', 'valider', 'photos', 'auteur', 'email', 'profil_id'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    public function signalerAnecdote()
    {
        return $this->hasMany('App\Models\SignalerAnecdote');
    }

    protected $dispatchesEvents = [
        'created' => AnecdoteEventCreated::class,
    ];
}
