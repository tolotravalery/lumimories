<?php


namespace App\Models;


use App\Events\CheckgenealogieEventCreated;
use Illuminate\Database\Eloquent\Model;

class Checkgenealogie extends Model
{
    protected $table = 'checkgenealogies';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'profil_id', 'profil_value_id','status','valider'
    ];

    public function profil()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    public function profil_value()
    {
        return $this->belongsTo('App\Models\Profil');
    }

    protected $dispatchesEvents = [
        'created' => CheckgenealogieEventCreated::class,
    ];
}
