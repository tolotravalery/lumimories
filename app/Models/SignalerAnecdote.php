<?php

namespace App\Models;

use App\Events\SignalerEvent;
use Illuminate\Database\Eloquent\Model;

class SignalerAnecdote extends Model
{
    protected $table = 'signaleranecdotes';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'raison', 'anecdote_id'
    ];

    public function anecdote()
    {
        return $this->belongsTo('App\Models\Anecdote');
    }


}
