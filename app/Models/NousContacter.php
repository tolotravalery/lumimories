<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class NousContacter  extends Model
{
    protected $fillable = [
        'nom','prenom','tel','objet','email','message'
    ];
}