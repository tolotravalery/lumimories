<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaires';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'commentaire', 'photo_id', 'user_id'
    ];

    public function photo()
    {
        return $this->belongsTo('App\Models\Photo');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}