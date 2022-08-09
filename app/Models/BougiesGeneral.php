<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class BougiesGeneral extends Model
{
    protected $table = 'bougiesgenerals';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'nbreBougie',
    ];

}