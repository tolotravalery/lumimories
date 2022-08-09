<?php

namespace App\Repositories\Implementations;


use App\Models\BougiesGeneral;
use App\Models\Checkgenealogie;
use App\Models\Contact;
use App\Models\Monument;
use App\Models\Profil;
use App\Models\Signaler;
use App\Repositories\IProfilRepository;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProfilRepository implements IProfilRepository
{

    public function save(Profil $profil)
    {
        return Profil::create([
            'nom' => $profil->nom,
            'prenoms' => $profil->prenoms,
            'photoProfil' => $profil->photoProfil,
            'sexe' => $profil->sexe,
            'dateDeces' => $profil->dateDeces,
            'dateNaissance' => $profil->dateNaissance,
            'pays' => $profil->pays,
            'biographie' => $profil->biographie,
            'motifDeces' => $profil->motifDeces,
            'division' => $profil->division,
            'allee' => $profil->allee,
            'rang' => $profil->rang,
            'numero' => $profil->numero,
            'user_id' => $profil->user_id,
            'surnom' => $profil->surnom,
            'paysDeNaissance' => $profil->paysDeNaissance,
            'nomDeJeuneFille' => $profil->nomDeJeuneFille,
            'genealogie' => $profil->genealogie,
            'villesHabitees' => $profil->villesHabitees,
            'validerParAdmin' => true,
            'photometa' => $profil->photometa,
            'lieuRepos' => $profil->lieuRepos,
            'nomCimitiere' => $profil->nomCimitiere,
            'carteCimitiere' => $profil->carteCimitiere,
            'regleNom' => $profil->regleNom,
            'religion' => $profil->religion,
            'profession' => $profil->profession,
        ]);
    }


    public function getRecentProfil($nombre)
    {
        return Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->take($nombre)->get();
    }

    public function getProfilById($id)
    {
        return Profil::findOrFail($id);
    }

    public function getProfilsById($list_id)
    {
        if ($list_id == null) return Profil::where('validerParAdmin', '=', true)->whereIn('id', $list_id)->get();
        else {
            $rawOrder = DB::raw(sprintf('FIELD(id, %s)', implode(',', $list_id)));
            return Profil::where('validerParAdmin', '=', true)->whereIn('id', $list_id)->orderByRaw($rawOrder)->get();
        }
    }

    public function findProfils($q, $sexe, $paginate)
    {
        $qSplit = explode(" ", $q);
        $profils = null;
        if (count($qSplit) == 1) {
            if ($q != null) {
                if ($sexe == "tous") $profils = Profil::where('nom', 'LIKE', '%' . $q . '%')->orWhere('prenoms', 'LIKE', '%' . $q . '%')->orWhere('surnom', 'LIKE', '%' . $q . '%')->get();
                else $profils = Profil::where('sexe', 'LIKE', $sexe)->where('nom', 'LIKE', '%' . $q . '%')->orWhere('prenoms', 'LIKE', '%' . $q . '%')->orWhere('surnom', 'LIKE', '%' . $q . '%')->get();
            } else {
                if ($sexe == "tous") $profils = Profil::where('validerParAdmin', '=', true)->get();
                else $profils = Profil::where('sexe', 'LIKE', $sexe)->where('validerParAdmin', '=', true)->get();
            }
        } else {
            if ($sexe == "tous") {
                $profils = Profil::where(function ($query) use ($qSplit) {
                    foreach ($qSplit as $qMot) {
                        $query->orWhere('nom', 'LIKE', "%.$qMot.%")->orWhere('prenoms', 'LIKE', '%' . $qMot . '%')->orWhere('surnom', 'LIKE', '%' . $qMot . '%');
                    }
                })->get();
            } else {
                $profils = Profil::where('sexe', 'LIKE', $sexe)->where(function ($query) use ($qSplit) {
                    foreach ($qSplit as $qMot) {
                        $query->orWhere('nom', 'LIKE', "%.$qMot.%")->orWhere('prenoms', 'LIKE', '%' . $qMot . '%')->orWhere('surnom', 'LIKE', '%' . $qMot . '%');
                    }
                })->get();
            }
        }
        $response = array();
        $profilsTab = array();
        foreach ($profils as $profil) {
            $egalite = 0;
            foreach ($qSplit as $qMot) {
                //if(strcasecmp($profil->nom, $qMot) == 0 || strcasecmp($profil->prenoms, $qMot) == 0 || strcasecmp($profil->surnom, $qMot) == 0) $egalite ++;
                if (stripos($profil->nom, $qMot) !== false || stripos($profil->prenoms, $qMot) !== false || stripos($profil->surnom, $qMot) !== false) $egalite++;
            }
            if ($egalite == count($qSplit)) $profilsTab[] = $profil;
        }
        if ($qSplit[0] == "" && count($qSplit) == 1) {
            $profilsTab = $profils;
        }
        foreach ($profilsTab as $p) {
            if ($sexe == "tous") {
                if ($p->validerParAdmin == true) $response[] = $p;
            } else {
                if ($p->validerParAdmin == true && strcmp($p->sexe, $sexe) == 0) $response[] = $p;
            }
        }
        return $this->paginate($response, $paginate);
    }

    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return (new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
            ]
        ));
    }

    public function findProfilsByNameAndSexe($term, $sexe)
    {
        //return Profil::where('validerParAdmin', '=', true)->where('sexe', 'LIKE', $sexe)->where('nom', 'LIKE', '%' . $term . '%')->orWhere('prenoms', 'LIKE', '%' . $term . '%')->orWhere('surnom', 'LIKE', '%' . $term . '%')->get();
        /*return Profil::where([
            ['nom', 'LIKE', '%' . $term . '%'],
            ['validerParAdmin', '=', true],
            ['sexe', 'LIKE', $sexe],
        ])->orWhere([
            ['prenoms', 'LIKE', '%' . $term . '%'],
            ['surnom', 'LIKE', '%' . $term . '%']
        ])->get();*/
        $profil = Profil::where('nom', 'like', '%' . $term . '%')->orWhere('prenoms', 'LIKE', '%' . $term . '%')->orWhere('surnom', 'LIKE', '%' . $term . '%')->get();
        $response = array();
        foreach ($profil as $p) {
            if ($p->validerParAdmin == true && strcmp($p->sexe, $sexe) == 0) $response[] = $p;
        }
        return $response;
    }

    public function getCheckGenealogiesById($list_id)
    {
        return Checkgenealogie::whereIn('id', $list_id)->orderBy('id', 'DESC')->get();
    }

    public function getProfilsByNameAndFirstName($arrayNoms, $arrayPrenoms)
    {
        return Profil::where('validerParAdmin', '=', true)->whereIn('prenoms', $arrayPrenoms)->whereIn('nom', $arrayNoms)->get(['id', 'prenoms', 'nom']);
    }

    public function saveCheckGenealogie($profil, $profil_value, $status)
    {
        $chk = Checkgenealogie::where('profil_id', '=', $profil)->where('profil_value_id', '=', $profil_value)->where('status', 'like', $status)->get();
        if (count($chk) == 0) {
            return Checkgenealogie::create([
                'profil_id' => $profil,
                'profil_value_id' => $profil_value,
                'status' => $status
            ]);
        }
    }

    public function isCheckGenealogie($profil, $profil_value)
    {
        return Checkgenealogie::where('profil_id', '=', $profil)->where('profil_value_id', '=', $profil_value)->get();
    }

    public function saveSignaler(Signaler $signaler)
    {
        Signaler::create([
            'raison' => $signaler->raison,
            'profil_id' => $signaler->profil_id,
        ]);
    }

    public function saveMonument(Monument $monument)
    {
        return Monument::create([
            'images' => $monument->images,
            'profil_id' => $monument->profil->id,
            'titreDuMonument' => $monument->titreDuMonument,
            'adresseDuMonument' => $monument->adresseDuMonument
        ]);
    }

    public function getProfils()
    {
        return Profil::where('validerParAdmin', '=', true)->get();
    }

    public function nbreBougieTotal()
    {
        return Profil::where('validerParAdmin', '=', true)->sum('nbreBougie');
    }

    public function getPreviousOrNext($id, $comparaison, $name, $order)
    {
        //return Profil::where('validerParAdmin', '=', true)->where('id', $comparaison, $id)->orWhere('prenoms', 'LIKE', '%' . $name . '%')->orWhere('prenoms', 'LIKE', '%' . $name . '%')->orWhere('surnom', 'LIKE', '%' . $name . '%')->orderBy('id', $order)->first();
        return Profil::where('validerParAdmin', '=', true)->where('id', $comparaison, $id)->orderBy('id', $order)->first();
        //dd(Profil::where('validerParAdmin', '=', true)->orderBy('nom', $order)->get());
    }

    public function getProfilWhoDiedNow($paginate = null)
    {
        if ($paginate != null) return Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->whereMonth('dateDeces', Carbon::today()->month)->whereDay('dateDeces', Carbon::today()->day)->paginate($paginate);
        else return Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->whereMonth('dateDeces', Carbon::today()->month)->whereDay('dateDeces', Carbon::today()->day)->get();
    }

    public function findProfilsByName($term)
    {
        return Profil::where('validerParAdmin', '=', true)->where('nom', 'LIKE', '%' . $term . '%')->orWhere('prenoms', 'LIKE', '%' . $term . '%')->orWhere('surnom', 'LIKE', '%' . $term . '%')->get();
    }

    public function saveContact(Contact $contact)
    {
        Contact::create([
            'auteur' => $contact->auteur,
            'email' => $contact->email,
            'profil_id' => $contact->profil_id,
            'message' => $contact->message
        ]);
    }

    public function getProfilByUser($user, $paginate = null)
    {
        if ($paginate != null) return Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->where('user_id', '=', $user->id)->paginate($paginate);
        else return Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->where('user_id', '=', $user->id)->get();
    }

    public function findProfilsExtra($q, $sexe, $ville, $religion, $paginate)
    {
        $qSplit = explode(" ", $q);
        $profils = null;
        if (count($qSplit) == 1) {
            if ($q != null) {
                if ($sexe == "tous") $profils = Profil::where('nom', 'LIKE', '%' . $q . '%')->orWhere('prenoms', 'LIKE', '%' . $q . '%')->orWhere('surnom', 'LIKE', '%' . $q . '%')->where('villesHabitees', 'LIKE', '%' . $ville . '%')->get();
                else $profils = Profil::where('sexe', 'LIKE', $sexe)->where('nom', 'LIKE', '%' . $q . '%')->orWhere('prenoms', 'LIKE', '%' . $q . '%')->orWhere('surnom', 'LIKE', '%' . $q . '%')->where('villesHabitees', 'LIKE', '%' . $ville . '%')->get();
            } else {
                if ($sexe == "tous") $profils = Profil::where('villesHabitees', 'LIKE', '%' . $ville . '%')->where('validerParAdmin', '=', true)->get();
                else $profils = Profil::where('sexe', 'LIKE', $sexe)->where('villesHabitees', 'LIKE', '%' . $ville . '%')->where('validerParAdmin', '=', true)->get();
            }
        } else {
            if ($sexe == "tous") {
                $profils = Profil::where(function ($query) use ($qSplit, $ville) {
                    foreach ($qSplit as $qMot) {
                        $query->orWhere('nom', 'LIKE', "%.$qMot.%")->orWhere('prenoms', 'LIKE', '%' . $qMot . '%')->orWhere('surnom', 'LIKE', '%' . $qMot . '%')->where('villesHabitees', 'LIKE', '%' . $ville . '%');
                    }
                })->get();
            } else {
                $profils = Profil::where('sexe', 'LIKE', $sexe)->where(function ($query) use ($qSplit, $ville) {
                    foreach ($qSplit as $qMot) {
                        $query->orWhere('nom', 'LIKE', "%.$qMot.%")->orWhere('prenoms', 'LIKE', '%' . $qMot . '%')->orWhere('surnom', 'LIKE', '%' . $qMot . '%')->where('villesHabitees', 'LIKE', '%' . $ville . '%');
                    }
                })->get();
            }
        }
        $response = array();
        $profilsTab = array();
        foreach ($profils as $profil) {
            $egalite = 0;
            foreach ($qSplit as $qMot) {
                if (stripos($profil->nom, $qMot) !== false || stripos($profil->prenoms, $qMot) !== false || stripos($profil->surnom, $qMot) !== false) $egalite++;
            }
            if ($egalite == count($qSplit)) $profilsTab[] = $profil;
        }
        if ($qSplit[0] == "" && count($qSplit) == 1) {
            $profilsTab = $profils;
        }
        foreach ($profilsTab as $p) {
            if ($sexe == "tous") {
                if ($p->validerParAdmin == true) $response[] = $p;
            } else {
                if ($p->validerParAdmin == true && strcmp($p->sexe, $sexe) == 0) $response[] = $p;
            }
        }
        $responses = array();
        foreach ($response as $rep) {
            if ($religion == null) {
                $responses[] = $rep;
            } else if ($religion != null) {
                if (strcasecmp($religion, $rep->religion) == 0) $responses[] = $rep;
            }
        }
        return $this->paginate($responses, $paginate);
    }

    public function getAllProfils($order)
    {
        return Profil::orderBy('id', $order)->get();
    }

}
