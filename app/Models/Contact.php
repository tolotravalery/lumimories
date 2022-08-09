<?php

namespace App\Models;

use App\Events\ContactEventCreated;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'auteur','email','profil_id','message'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    protected $dispatchesEvents = [
        'created' => ContactEventCreated::class,
    ];
}
