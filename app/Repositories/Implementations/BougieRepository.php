<?php
namespace App\Repositories\Implementations;

use App\Models\Bougie;
use App\Models\BougiesGeneral;
use App\Repositories\IBougieRepository;

class BougieRepository implements IBougieRepository
{

    public function save(Bougie $bougie)
    {
        Bougie::create([
            'message' => $bougie->message == null ? "" : $bougie->message,
            'nom' => $bougie->nom == null ? "" : $bougie->nom,
            'profil_id' => $bougie->profil_id
        ]);
    }

    public function getNombreBougiesGenerals()
    {
        $bougie = BougiesGeneral::find(1);
        return $bougie->nbreBougie;
    }

    public function allumerBougiesGenerals()
    {
        $bougie = BougiesGeneral::find(1);
        $bougie->nbreBougie ++;
        $bougie->save();
    }
}
