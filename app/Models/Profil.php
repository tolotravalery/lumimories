<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profil extends Model
{
    protected $table = 'profils';
    protected $guarded = [
        'id'
    ];
    protected $fillable = [
        'nom', 'prenoms', 'photoProfil', 'sexe', 'dateDeces', 'dateNaissance', 'pays', 'biographie', 'motifDeces', 'categorie', 'star', 'nbreBougie', 'monument', 'user_id', 'validerParAdmin',
        'nomDeJeuneFille', 'surnom', 'paysDeNaissance', 'genealogie', 'villesHabitees', 'division', 'allee', 'numero', 'rang', 'photometa', 'lieuRepos', 'nomCimitiere', 'carteCimitiere', 'regleNom',
        'religion','profession','operation','photoanniveraire'
    ];

    public function nomFirstProfil()
    {
        $nom = '';
        $nom = strtoupper($this->prenoms .' '.$this->nom);
        $nom1 = $this->nomDeJeuneFille != null ? ucwords(__('website.born')." ". $this->nomDeJeuneFille ): "";
        if($this->regleNom == true){
            $nom = $nom . " ". $nom1;
        }
        else $nom = $this->surnom != null ? ucwords($this->surnom) : $nom = $nom . " ". $nom1;
        return $nom;
    }
    public function nomSecondProfil()
    {
        $nom = '';
        if($this->regleNom == true)  $nom = $this->surnom != null ? "(".$this->surnom.")" : " ";
        else{
            $nom = $this->prenoms .' '.$this->nom;
            $nom1 = $this->nomDeJeuneFille != null ? __('website.born')." ".$this->nomDeJeuneFille : "";
            $nom = $this->surnom != null ? $nom . " ". $nom1 : "";
        }
        return $nom;
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function photos()
    {
        return $this->hasMany('App\Models\Photo');
    }

    public function anecdotes()
    {
        return $this->hasMany('App\Models\Anecdote');
    }

    public function bougies()
    {
        return $this->hasMany('App\Models\Bougie');
    }

    public function checkgenealogie()
    {
        return $this->hasMany('App\Models\Checkgenealogie');
    }

    public function usersSuivre()
    {
        return $this->belongsToMany('App\Models\User', 'user_profil', 'profil_suivre_id', 'user_suivre_id');
    }

    public function signaler()
    {
        return $this->hasMany('App\Models\Signaler');
    }

    public function monuments()
    {
        return $this->hasMany('App\Models\Monument');
    }
}
