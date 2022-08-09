<?php

namespace App\Models;

use App\Events\SignalerEvent;
use Illuminate\Database\Eloquent\Model;

class Signaler extends Model
{
    protected $table = 'signaler';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'raison', 'profil_id'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    protected $dispatchesEvents = [
        'created' => SignalerEvent::class,
    ];
}
