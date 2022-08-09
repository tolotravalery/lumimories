<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Monument extends Model
{
    protected $table = 'monuments';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'images','profil_id','titreDuMonument','adresseDuMonument'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }
}
