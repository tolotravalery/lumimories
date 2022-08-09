<?php

namespace App\Models;

use App\Events\BougieEventCreated;
use Illuminate\Database\Eloquent\Model;

class Bougie extends Model
{
    protected $table = 'bougies';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'message', 'nom', 'profil_id'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    protected $dispatchesEvents = [
        'created' => BougieEventCreated::class,
        'restored' => BougieEventCreated::class,
    ];
}
