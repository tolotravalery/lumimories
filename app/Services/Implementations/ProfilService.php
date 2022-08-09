<?php

namespace App\Services\Implementations;

use App\Http\Controllers\InvalidationProfilMail;
use App\Http\Controllers\ValidationProfilMail;
use App\Models\Bougie;
use App\Models\Checkgenealogie;
use App\Models\Contact;
use App\Models\Monument;
use App\Models\NousContacter;
use App\Models\Profil;
use App\Models\Signaler;
use App\Models\User;
use App\Notifications\AllumerBougie;
use App\Notifications\AnniversaireDeces;
use App\Notifications\NousContacterNotification;
use App\Repositories\Implementations\BougieRepository;
use App\Repositories\IPhotoRepository;
use App\Repositories\IProfilRepository;
use App\Repositories\IUserRepository;
use App\Services\IGeneralService;
use App\Services\IProfilService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class ProfilService implements IProfilService
{
    private $repository;
    private $bougieRepository;
    private $userRepository;
    private $generalService;
    private $photoRepository;

    public function __construct(IProfilRepository $repository, BougieRepository $bougieRepository, IUserRepository $userRepository, IGeneralService $generalService, IPhotoRepository $photoRepository)
    {
        $this->repository = $repository;
        $this->bougieRepository = $bougieRepository;
        $this->userRepository = $userRepository;
        $this->generalService = $generalService;
        $this->photoRepository = $photoRepository;
    }

    public function getRecentProfil($nombre)
    {
        return $this->repository->getRecentProfil($nombre);
    }

    public function getProfilById($id)
    {
        return $this->repository->getProfilById($id);
    }

    public function getProfilsById($id)
    {
        return $this->repository->getProfilsById($id);
    }

    public function getFamilyByProfil($profil)
    {
        $gene = array();
        $profils = array();
        $adjectifs = array();
        if (isset($profil->genealogie)) {
            $textGenealogie = explode("|", $profil->genealogie);
            $pere = explode(",", str_replace("P:", "", $textGenealogie[0]));
            $mere = explode(",", str_replace("M:", "", $textGenealogie[1]));
            $freres = explode(",", str_replace("F:", "", $textGenealogie[2]));
            $soeurs = explode(",", str_replace("S:", "", $textGenealogie[3]));
            $conjointH = explode(",", str_replace("CH:", "", $textGenealogie[4]));
            $conjointF = explode(",", str_replace("CF:", "", $textGenealogie[5]));
            $enfants = explode(",", str_replace("E:", "", $textGenealogie[6]));
            $result = array();
            $tableau = array();
            $tableau = $this->genealogyOfProfil($result, $gene, $pere, __("website.father"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $mere, __("website.mother"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $freres, __("website.brother"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $soeurs, __("website.sister"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $conjointH, __("website.husband"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $conjointF, __("website.wife"));
            $tableau = $this->genealogyOfProfil($tableau[0], $tableau[1], $enfants, __("website.child"));
            $result = $tableau[0];
            $gene = $tableau[1];
            foreach ($gene as $g) {
                $adjectifs[] = $this->adjectifPossessifs($g);
            }
            $profils = $this->getProfilsById($result);
        }
        $tab = array($profils, $gene, $adjectifs);
        return $tab;
    }

    private function genealogyOfProfil($result, $genealogie, $status, $label)
    {
        foreach ($status as $p) {
            if ($p != "") {
                $i = count($result);
                $result[$i] = $p;
                $genealogie[$i] = $label;
                $i++;
            }
        }
        return array($result, $genealogie);
    }

    public function addNombreBougieProfil($id)
    {
        $profil = $this->getProfilById($id);
        $profil->nbreBougie++;
        $profil->save();
    }

    public function allumerBougie(Request $request)
    {
        $bougie = new Bougie();
        $bougie->message = $request->input('message');
        $bougie->nom = $request->input('nom');
        $bougie->profil_id = $request->input('profil');
        if (Auth::check()) {
            if (Auth::user()->email == $bougie->profil->user->email) {
                $bougie->flushEventListeners();
            }
        }
        //$this->bougieRepository->save($bougie);
        $this->addNombreBougieProfil($bougie->profil_id);
        $this->bougieRepository->allumerBougiesGenerals();
        Notification::send($bougie->profil->user, new AllumerBougie($bougie));
    }

    public function validatorRecherche(array $data)
    {
        return Validator::make($data,
            [
                'dateDebut' => 'nullable|date',
                'dateFin' => 'nullable|date|after_or_equal:dateDebut',
            ]
        );
    }

    public function findProfils(Request $request, $paginate)
    {
        $this->validatorRecherche($request->all())->validate();
        return $this->repository->findProfils($request->input('q'), $request->input('sexe'), $paginate);
    }

    public function findProfilsByNameAndSexe($term, $sexe)
    {
        $profils = $this->repository->findProfilsByNameAndSexe($term, $sexe);
        $response = array();
        if (isset($profils)) {
            foreach ($profils as $p) {
                $nom = $p->prenoms . " " . $p->nom;
                $image = explode("|", $p->photoProfil)[0] ? asset(explode("|", $p->photoProfil)[0]) : asset("/public/photo-profiles/default.jpg");
                //$nom = $p->surnom ? $nom . "(" . $p->surnom . ")" : $nom;
                $response[] = array("value" => $p->id, "label" => $nom, "image" => $image);
            }
        }
        return response()->json($response);
    }

    private function genealogie($status, $value)
    {
        $profil = $this->getProfilById($value);
        $tabHomme = array("father","brother","husband","child");
        $tabFemme = array("mother","sister","wife","child");
        if($profil->sexe == "Femme"){
            $id = array_search($status,$tabFemme);
            if($id ==  false){
                $id = array_search($status,$tabHomme);
                $status = $tabFemme[$id];
            }
        }
        else if($profil->sexe == "Homme"){
            $id = array_search($status,$tabHomme);
            if($id ==  false){
                $id = array_search($status,$tabFemme);
                $status = $tabHomme[$id];
            }
        }
        $reponse = "";
        if (__('website.'.$status) == __('website.father')) $reponse = "P:" . $value;
        elseif (__('website.'.$status) == __('website.mother')) $reponse = "M:" . $value;
        elseif (__('website.'.$status) == __('website.brother')) $reponse = "F:" . $value;
        elseif (__('website.'.$status) == __('website.sister')) $reponse = "S:" . $value;
        elseif (__('website.'.$status) == __('website.husband')) $reponse = "CH:" . $value;
        elseif (__('website.'.$status) == __('website.wife')) $reponse = "CF:" . $value;
        elseif (__('website.'.$status) == __('website.child')) $reponse = "E:" . $value;
        return $reponse;
    }

    private function concatenationGenealogie($recent, $nouveau)
    {
        $temp = explode(':', $nouveau)[0];
        if ($recent == null) {
            if ($temp == 'P') $recent = "P:" . explode(':', $nouveau)[1] . "|M:|F:|CH:|CF:|S:|E:";
            else if ($temp == 'M') $recent = "P:|M:" . explode(':', $nouveau)[1] . "|F:|CH:|CF:|S:|E:";
            else if ($temp == 'F') $recent = "P:|M:|F:" . explode(':', $nouveau)[1] . "|S:|CH:|CF:|E:";
            else if ($temp == 'S') $recent = "P:|M:|F:|S:" . explode(':', $nouveau)[1] . "|CH:|CF:|E:";
            else if ($temp == 'CH') $recent = "P:|M:|F:|S:|CH:" . explode(':', $nouveau)[1];
            else if ($temp == 'CF') $recent = "P:|M:|F:|S:|CH:|CF:" . explode(':', $nouveau)[1];
            else if ($temp == 'E') $recent = "P:|M:|F:|S:|CH:|CF:|E:" . explode(':', $nouveau)[1];
        } else {
            $textGenealogie = explode("|", $recent);
            $pere = str_replace("P:", "", $textGenealogie[0]);
            $mere = str_replace("M:", "", $textGenealogie[1]);
            $freres = str_replace("F:", "", $textGenealogie[2]);
            $soeurs = str_replace("S:", "", $textGenealogie[3]);
            $conjointH = str_replace("CH:", "", $textGenealogie[4]);
            $conjointF = str_replace("CF:", "", $textGenealogie[5]);
            $enfants = str_replace("E:", "", $textGenealogie[6]);
            $p = "";
            $f = "";
            $s = "";
            $ch = "";
            $cf = "";
            $m = "";
            $e = "";
            if ($temp == 'P') $p = $pere == "" ? explode(':', $nouveau)[1] : $pere . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'M') $m = $mere == "" ? explode(':', $nouveau)[1] : $mere . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'F') $f = $freres == "" ? explode(':', $nouveau)[1] : $freres . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'S') $s = $soeurs == "" ? explode(':', $nouveau)[1] : $soeurs . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'CH') $ch = $conjointH == "" ? explode(':', $nouveau)[1] : $conjointH . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'CF') $cf = $conjointF == "" ? explode(':', $nouveau)[1] : $conjointF . ',' . explode(':', $nouveau)[1];
            else if ($temp == 'E') $e = $enfants == "" ? explode(':', $nouveau)[1] : $enfants . ',' . explode(':', $nouveau)[1];
            $p = $this->concatenationString($pere, $p);
            $m = $this->concatenationString($mere, $m);
            $f = $this->concatenationString($freres, $f);
            $s = $this->concatenationString($soeurs, $s);
            $ch = $this->concatenationString($conjointH, $ch);
            $cf = $this->concatenationString($conjointF, $cf);
            $e = $this->concatenationString($enfants, $e);
            $recent = "P:" . $p . "|M:" . $m . "|F:" . $f . "|S:" . $s . "|CH:" . $ch . "|CF:" . $cf . "|E:" . $e;
        }
        return $recent;
    }

    private function concatenationString($val1, $val2)
    {
        return $val1 == null ? ($val2 != null && $val1 != null ? $val1 . "," . $val2 : $val2) : ($val2 == null && $val1 == null ? null : ($val2 != null && $val1 == null ? $val1 : ($val2 == null && $val1 != null ? $val1 : $val2)));
    }

    public function getCheckGenealogiesById($list_id)
    {
        if($list_id == null) return null;
        $checks = $this->repository->getCheckGenealogiesById($list_id);
        foreach ($checks as $p) {
            $profil = $p->profil;
            $nouveau = $this->genealogie($p->status, $p->profil_value->id);
            $profil->genealogie = $this->concatenationGenealogie($profil->genealogie, $nouveau);
            $p->valider = true;
            $p->save();
            $profil->save();
        }
        return $checks;
    }

    public function validatorProfil(array $data)
    {
        return Validator::make($data,
            [
                'email' => 'required|email',
                'password' => 'required',
                'nom' => 'required|max:200',
                'prenom1' => 'required|max:50',
                'photoProfil' => 'max:200',
                'photoProfil.*' => 'mimes:jpg,jpeg,png',
                'sexe' => 'required',
                'dateNaissance' => 'nullable|date',
                'dateDeces' => 'required|date|after_or_equal:dateNaissance|before_or_equal:' . date('d-m-Y'),
                'pays' => 'required',
            ],
            ['after_or_equal' => __('website.custom-error-message-datedeces'),]
        );
    }

    public function validatorProfilUserConnected(array $data)
    {
        return Validator::make($data,
            [
                'nom' => 'required|max:200',
                'prenom1' => 'required|max:50',
                'photoProfil' => 'max:200',
                'photoProfil.*' => 'mimes:jpg,jpeg,png',
                'sexe' => 'required',
                'dateNaissance' => 'nullable|date',
                'dateDeces' => 'required|date|after_or_equal:dateNaissance|before_or_equal:' . date('d-m-Y'),
                'pays' => 'required',
            ],
            ['after_or_equal' => __('website.custom-error-message-datedeces'),]
        );
    }

    private function transformationNameToGenealogy($nomPere, $nomMere, $nomFrere, $nomSoeur)
    {
        $nomPere = $this->transformationNameWithoutComa($nomPere);
        $nomMere = $this->transformationNameWithoutComa($nomMere);
        $nomFrere = $this->transformationNameWithoutComa($nomFrere);
        $nomSoeur = $this->transformationNameWithoutComa($nomSoeur);
        $status = array();
        $status = $this->createStatus($status, $nomPere, "P");
        $status = $this->createStatus($status, $nomMere, "M");
        $status = $this->createStatus($status, $nomFrere, "F");
        $status = $this->createStatus($status, $nomSoeur, "S");

        $noms = $nomPere == null ? null : $nomPere;
        $noms = $this->concatenationNameGenealogie($noms, $nomMere);
        $noms = $this->concatenationNameGenealogie($noms, $nomFrere);
        $noms = $this->concatenationNameGenealogie($noms, $nomSoeur);

        $array = explode(",", $noms);
        $arrayPrenoms = array();
        $arrayNoms = array();
        foreach ($array as $a) {
            $temp = explode(" ", $a);
            $arrayPrenoms[] = isset($temp[0]) ? $temp[0] : null;
            $arrayNoms[] = isset($temp[1]) ? $temp[1] : null;
        }

        $profils = $this->repository->getProfilsByNameAndFirstName($arrayNoms, $arrayPrenoms);
        $tempPere = array();
        $tempMere = array();
        $tempFrere = array();
        $tempSoeur = array();
        foreach ($profils as $p) {
            for ($i = 0; $i < count($array); $i++) {
                if ($arrayPrenoms[$i] == $p->prenoms && $arrayNoms[$i] == $p->nom) {
                    if ($status[$i] == "P") $tempPere[$i] = $p->id;
                    elseif ($status[$i] == "M") $tempMere[$i] = $p->id;
                    elseif ($status[$i] == "F") $tempFrere[$i] = $p->id;
                    elseif ($status[$i] == "S") $tempSoeur[$i] = $p->id;
                }
            }
        }
        $reponse = array();
        $reponse[0] = $tempPere;
        $reponse[1] = $tempMere;
        $reponse[2] = $tempFrere;
        $reponse[3] = $tempSoeur;
        return $reponse;
    }

    private function transformationNameWithoutComa($name)
    {
        return substr($name, -1) == ',' ? substr($name, 0, -1) : $name;
    }

    private function createStatus($status, $name, $variable)
    {
        if ($name != null) {
            foreach (explode(",", $name) as $temp) {
                $status[] = $variable;
            }
        }
        return $status;
    }

    private function concatenationNameGenealogie($noms, $nomVariable)
    {
        return $noms == null ? ($nomVariable != null && $noms != null ? $noms . "," . $nomVariable : $nomVariable) : ($nomVariable == null && $noms == null ? null : ($nomVariable != null && $noms == null ? $noms : ($nomVariable == null && $noms != null ? $noms : $noms . "," . $nomVariable)));
    }

    public static function slugify($text, string $divider = '-')
    {
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, $divider);
        $text = preg_replace('~-+~', $divider, $text);
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    public function save(Request $request, $user)
    {
        $pere = is_array($request->input('nomPereNumber')) == false ? ($request->input('nomPereNumber') == null ? "" : $request->input('nomPereNumber')) : implode(",", $request->input('nomPereNumber'));
        $mere = is_array($request->input('nomMereNumber')) == false ? ($request->input('nomMereNumber') == null ? "" : $request->input('nomMereNumber')) : implode(",", $request->input('nomMereNumber'));
        $freres = is_array($request->input('nomFreresNumber')) == false ? ($request->input('nomFreresNumber') == null ? "" : $request->input('nomFreresNumber')) : implode(",", $request->input('nomFreresNumber'));
        $soeurs = is_array($request->input('nomSoeursNumber')) == false ? ($request->input('nomSoeursNumber') == null ? "" : $request->input('nomSoeursNumber')) : implode(",", $request->input('nomSoeursNumber'));
        $conjointH = is_array($request->input('nomCHNumber')) == false ? ($request->input('nomCHNumber') == null ? "" : $request->input('nomCHNumber')) : implode(",", $request->input('nomCHNumber'));
        $conjointF = is_array($request->input('nomCFNumber')) == false ? ($request->input('nomCFNumber') == null ? "" : $request->input('nomCFNumber')) : implode(",", $request->input('nomCFNumber'));
        $genealogie = "P:" . $pere . "|M:" . $mere . "|F:" . $freres . "|S:" . $soeurs . "|CH:" . $conjointH . "|CF:" . $conjointF . "|E:";
        $tempPere = explode(',', $pere);
        $tempMere = explode(',', $mere);
        $tempFrere = explode(',', $freres);
        $tempSoeur = explode(',', $soeurs);
        $tempConjointH = explode(',', $conjointH);
        $tempConjointF = explode(',', $conjointF);
        $reponse = array();
        $reponse[0] = $tempPere;
        $reponse[1] = $tempMere;
        $reponse[2] = $tempFrere;
        $reponse[3] = $tempSoeur;
        $reponse[4] = $tempConjointH;
        $reponse[5] = $tempConjointF;
        $prenoms = $this->concatWords(' ', $request->input('prenom1'), $request->input('prenom2'), $request->input('prenom3'), $request->input('prenom4'), $request->input('prenom5'), $request->input('prenom6'), $request->input('prenom7'), $request->input('prenom8'), $request->input('prenom9'), $request->input('prenom10'));
        $villesHabitees = $this->concatWords(', ', $request->input('villesHabitee1'), $request->input('villesHabitee2'), $request->input('villesHabitee3'), $request->input('villesHabitee4'), $request->input('villesHabitee5'), $request->input('villesHabitee6'), $request->input('villesHabitee7'), $request->input('villesHabitee8'), $request->input('villesHabitee9'), $request->input('villesHabitee10'));
        $images = $this->generalService->uploadImagesProfil(self::slugify($request->input('nom') . "-" . $prenoms), '/photo-profiles/', $request->file('photoProfil'));
        //$imagesMonuments = $this->generalService->uploadImagesProfil(self::slugify("monument-" . $request->input('nom') . "-" . $prenoms), '/photo-monuments/', $request->file('monuments'));
        $profil = new Profil();
        $profil->nom = $request->input('nom');
        $profil->prenoms = $prenoms;
        $profil->photoProfil = $images;
        $profil->photometa = $this->generalService->mergeImages(explode("|", $images)[0] ? explode("|", $images)[0] : "public/photo-profiles/default.jpg", 'public/front/img/bougie-removebg-preview.png');
        $profil->sexe = $request->input('sexe');
        $profil->dateDeces = new Carbon($request->input('dateDeces'));
        $profil->dateNaissance = $request->input('dateNaissance') == null ? null : new Carbon($request->input('dateNaissance'));
        $profil->pays = $request->input('pays');
        $profil->biographie = $request->input('biographie');
        $profil->motifDeces = $request->input('motifDeces');
        $profil->division = $request->input('division');
        $profil->allee = $request->input('allee');
        $profil->rang = $request->input('rang');
        $profil->numero = $request->input('numero');
        $profil->user_id = $user->id;
        $profil->surnom = $this->concatWords(' ', $request->input('surnom1'), $request->input('surnom2'), $request->input('surnom3'), $request->input('surnom4'), $request->input('surnom5'), $request->input('surnom6'), $request->input('surnom7'), $request->input('surnom8'), $request->input('surnom9'), $request->input('surnom10'));
        $profil->paysDeNaissance = $request->input('paysDeNaissance');
        $profil->nomDeJeuneFille = $request->input('nomDeJeuneFille');
        $profil->genealogie = $genealogie;
        $profil->villesHabitees = $villesHabitees;
        $profil->lieuRepos = $request->input('lieuRepos');
        $profil->nomCimitiere = $request->input('nomCimitiere');
        $profil->carteCimitiere = $request->input('carteCimitiere');
        $profil->regleNom = $request->input('regleNom') == '0' ? false : true;
        $profil->religion = $request->input('religion');
        $profil->profession = $request->input('profession');
        $profil = $this->repository->save($profil);
        /*if ($imagesMonuments != "") {
            $monument = new Monument();
            $monument->images = $imagesMonuments;
            $monument->profil_id = $profil->id;
            $monument = $this->repository->saveMonument($monument);
        }*/
        $i = 0;
        foreach ($reponse as $tempNow) {
            foreach ($tempNow as $t) {
                switch ($i) {
                    case 0:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 1:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 2:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "brother");
                        break;
                    case 3:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "sister");
                        break;
                    case 4:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "wife");
                        break;
                    case 5:
                        if ($t != null) $this->saveCheckGenealogie($t, $profil->id, "husband");
                        break;
                }
            }
            $i++;
        }
        return $profil;
    }

    private function saveCheckGenealogie($profil, $profil_value, $status)
    {
        return $this->repository->saveCheckGenealogie($profil, $profil_value, $status);
    }

    public function getFamilyByProfilInEdit($profil)
    {
        $pere = array();
        $mere = array();
        $frere = array();
        $soeur = array();
        $conjointH = array();
        $conjointF = array();
        $profils = $this->getFamilyByProfil($profil)[0];
        $gene = $this->getFamilyByProfil($profil)[1];
        $i = 0;
        foreach ($profils as $genealogie) {
            switch ($gene[$i]) {
                case __('website.father'):
                    $pere[] = $this->getCompleteInformation($genealogie);
                    break;
                case __('website.mother'):
                    $mere[] = $this->getCompleteInformation($genealogie);
                    break;
                case __('website.brother'):
                    $frere[] = $this->getCompleteInformation($genealogie);
                    break;
                case __('website.sister'):
                    $soeur[] = $this->getCompleteInformation($genealogie);
                    break;
                case __('website.husband'):
                    $conjointH[] = $this->getCompleteInformation($genealogie);
                    break;
                case __('website.wife'):
                    $conjointF[] = $this->getCompleteInformation($genealogie);
                    break;
            }
            $i++;
        }
        return array($pere, $mere, $frere, $soeur, $conjointH, $conjointF);
    }

    private function getCompleteInformation($profil)
    {
        return array($profil->id, $profil->prenoms . " " . $profil->nom);
    }

    private function isCheckGenealogie($profil, $profil_value)
    {
        $check = $this->repository->isCheckGenealogie($profil, $profil_value);
        return $check->isEmpty();
    }

    public function update(Request $request)
    {
        $pere = is_array($request->input('nomPereNumber')) == false ? ($request->input('nomPereNumber') == null ? "" : $request->input('nomPereNumber')) : implode(",", $request->input('nomPereNumber'));
        $mere = is_array($request->input('nomMereNumber')) == false ? ($request->input('nomMereNumber') == null ? "" : $request->input('nomMereNumber')) : implode(",", $request->input('nomMereNumber'));
        $freres = is_array($request->input('nomFreresNumber')) == false ? ($request->input('nomFreresNumber') == null ? "" : $request->input('nomFreresNumber')) : implode(",", $request->input('nomFreresNumber'));
        $soeurs = is_array($request->input('nomSoeursNumber')) == false ? ($request->input('nomSoeursNumber') == null ? "" : $request->input('nomSoeursNumber')) : implode(",", $request->input('nomSoeursNumber'));
        $conjointH = is_array($request->input('nomCHNumber')) == false ? ($request->input('nomCHNumber') == null ? "" : $request->input('nomCHNumber')) : implode(",", $request->input('nomCHNumber'));
        $conjointF = is_array($request->input('nomCFNumber')) == false ? ($request->input('nomCFNumber') == null ? "" : $request->input('nomCFNumber')) : implode(",", $request->input('nomCFNumber'));
        $genealogie = "P:" . $pere . "|M:" . $mere . "|F:" . $freres . "|S:" . $soeurs . "|CH:" . $conjointH . "|CF:" . $conjointF . "|E:";
        $tempPere = explode(',', $pere);
        $tempMere = explode(',', $mere);
        $tempFrere = explode(',', $freres);
        $tempSoeur = explode(',', $soeurs);
        $tempConjointH = explode(',', $conjointH);
        $tempConjointF = explode(',', $conjointF);
        $reponse = array();
        $reponse[0] = $tempPere;
        $reponse[1] = $tempMere;
        $reponse[2] = $tempFrere;
        $reponse[3] = $tempSoeur;
        $reponse[4] = $tempConjointH;
        $reponse[5] = $tempConjointF;
        $prenoms = $this->concatWords(' ', $request->input('prenom1'), $request->input('prenom2'), $request->input('prenom3'), $request->input('prenom4'), $request->input('prenom5'), $request->input('prenom6'), $request->input('prenom7'), $request->input('prenom8'), $request->input('prenom9'), $request->input('prenom10'));
        $villesHabitees = $this->concatWords(', ', $request->input('villesHabitee1'), $request->input('villesHabitee2'), $request->input('villesHabitee3'), $request->input('villesHabitee4'), $request->input('villesHabitee5'), $request->input('villesHabitee6'), $request->input('villesHabitee7'), $request->input('villesHabitee8'), $request->input('villesHabitee9'), $request->input('villesHabitee10'));
        $images = $this->generalService->uploadImagesProfil(self::slugify($request->input('nom') . "-" . $prenoms), "/photo-profiles/", $request->file('photoProfil'));
        //$imagesMonuments = $this->generalService->uploadImagesProfil(self::slugify($request->input('nom') . "-" . $prenoms), "/photo-monuments/", $request->file('monuments'));
        $profil = $this->getProfilById($request->input('id'));
        $genealogieTemp = $profil->genealogie;
        $enfant = explode('|E:', $genealogieTemp)[1];
        $genealogie = $genealogie . $enfant;
        $profil->nom = $request->input('nom');
        $profil->prenoms = $prenoms;
        $profil->sexe = $request->input('sexe');
        $profil->dateDeces = $request->input('dateDeces');
        $profil->dateNaissance = $request->input('dateNaissance');
        $profil->pays = $request->input('pays');
        $profil->biographie = $request->input('biographie');
        $profil->motifDeces = $request->input('motifDeces');
        $profil->division = $request->input('division');
        $profil->allee = $request->input('allee');
        $profil->rang = $request->input('rang');
        $profil->numero = $request->input('numero');
        $profil->photoProfil = empty($images) ? $profil->photoProfil : $images;
        $profil->photometa = empty($images) ? $profil->photometa : $this->generalService->mergeImages(explode("|", $images)[0] ? explode("|", $images)[0] : "public/photo-profiles/default.jpg", 'public/front/img/bougie-removebg-preview.png');
        $profil->surnom = $this->concatWords(' ', $request->input('surnom1'), $request->input('surnom2'), $request->input('surnom3'), $request->input('surnom4'), $request->input('surnom5'), $request->input('surnom6'), $request->input('surnom7'), $request->input('surnom8'), $request->input('surnom9'), $request->input('surnom10'));
        $profil->paysDeNaissance = $request->input('paysDeNaissance');
        $profil->nomDeJeuneFille = $request->input('nomDeJeuneFille');
        $profil->genealogie = $genealogie;
        $profil->villesHabitees = $villesHabitees;
        $profil->lieuRepos = $request->input('lieuRepos');
        $profil->nomCimitiere = $request->input('nomCimitiere');
        $profil->carteCimitiere = $request->input('carteCimitiere');
        $profil->regleNom = $profil->regleNom = $request->input('regleNom') == '0' ? false : true;
        $profil->religion = $request->input('religion');
        $profil->profession = $request->input('profession');
        $profil->save();
        /*if ($imagesMonuments != "") {
            $monument = new Monument();
            $monument->images = $imagesMonuments;
            $monument->profil_id = $profil->id;
            $monument = $this->repository->saveMonument($monument);
        }*/
        $i = 0;
        foreach ($reponse as $tempNow) {
            foreach ($tempNow as $t) {
                switch ($i) {
                    case 0:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 1:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 2:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "brother");
                        break;
                    case 3:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "sister");
                        break;
                    case 4:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "wife");
                        break;
                    case 5:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "husband");
                        break;
                }
            }
            $i++;
        }
        return $profil;
    }

    public function suivre(Profil $profil, User $user)
    {
        $ids = [$profil->id];
        $user->profilsSuivre()->toggle($ids);//eto
    }

    public function signaler(Request $request)
    {
        $signaler = new Signaler();
        $signaler->raison = $request->input('raison');
        $signaler->profil_id = $request->input('profil');
        $this->repository->saveSignaler($signaler);
    }

    public function concatWords($delimiter, ...$words)
    {
        $reponse = "";
        $i = 0;
        foreach ($words as $w) {
            if ($i == 0) $reponse = ($w == "" ? $reponse : $w);
            else {
                $reponse = ($w == "" ? $reponse : $reponse . $delimiter . $w);
            }
            $i++;
        }
        return $reponse;
    }

    public function splitWords($delimiter, $words)
    {
        return explode($delimiter, $words);
    }

    public function adjectifPossessifs($genealogie)
    {
        $reponse = __("website.his");
        $her = array(__("website.mother"), __("website.sister"));
        $reponse = in_array($genealogie, $her) != 0 ? __("website.her") : __("website.his");
        return $reponse;
    }

    public function allumerBougieGeneral(Request $request)
    {
        /*$profils = $this->repository->getProfils();
        foreach ($profils as $p) {
            $bougie = new Bougie();
            $bougie->message = $request->input('message');
            $bougie->profil_id = $p->id;
            $bougie->flushEventListeners();
            $this->bougieRepository->save($bougie);
            $this->addNombreBougieProfil($bougie->profil_id);
        }*/
        $this->bougieRepository->allumerBougiesGenerals();
    }

    public function nbreBougieTotal()
    {
        return $this->bougieRepository->getNombreBougiesGenerals();
    }

    public function getPreviousOrNext($id, $comparaison, $name, $order)
    {
        return $this->repository->getPreviousOrNext($id, $comparaison, $name, $order);
    }

    public function getProfilWhoDiedNow($paginate)
    {
        return $this->repository->getProfilWhoDiedNow($paginate);
    }

    public function mesPhotosValide(Profil $profil)
    {
        return $this->photoRepository->mesPhotosValide($profil);
    }

    public function findProfilsByName($term)
    {
        $profils = $this->repository->findProfilsByName($term);
        $response = array();
        if (isset($profils)) {
            foreach ($profils as $p) {
                $nom = $p->prenoms . " " . $p->nom;
                $image = explode("|", $p->photoProfil)[0] ? asset(explode("|", $p->photoProfil)[0]) : asset("/public/photo-profiles/default.jpg");
                //$nom = $p->surnom ? $nom . "(" . $p->surnom . ")" : $nom;
                $response[] = array("value" => $p->id, "label" => $nom, "image" => $image);
            }
        }
        return response()->json($response);
    }

    public function contacterAdmin(Request $request)
    {
        $contact = new Contact();
        $contact->auteur = $request->input('auteur');
        $contact->email = $request->input('email');
        $contact->profil_id = $request->input('profil');
        $contact->message = $request->input('message');
        $this->repository->saveContact($contact);

    }

    public function getProfilByUser($user, $paginate = null)
    {
        return $this->repository->getProfilByUser($user, $paginate);
    }

    public function deleteProfil($id)
    {
        $profil = $this->getProfilById($id);
        $this->supprimerDansGenealogie($id);
        $profil->delete();
    }

    public function visit(Profil $profil)
    {
        visits($profil)->forceIncrement();
        $profil->visit = visits($profil)->count();
        $profil->save();
    }

    public function findProfilsExtra(Request $request, $paginate)
    {
        return $this->repository->findProfilsExtra($request->input('q'), $request->input('sexe'),$request->input('ville'),$request->input('religion'), $paginate);
    }

    public function nbreProfil()
    {
        return count($this->repository->getProfils());
    }

    public function getAllProfils($order)
    {
        return $this->repository->getAllProfils($order);
    }

    public function checkValidation(Request $request)
    {
        $profil = $this->getProfilById($request->input('id'));
        //$request->input('status') == "valide" ? Mail::to($profil->user->email)->send(new ValidationProfilMail($profil)) :  Mail::to($profil->user->email)->send(new InvalidationProfilMail($profil));
        $request->input('status') == "valide" ?  $profil->validerParAdmin = true :  $profil->validerParAdmin = false;
        $profil->save();
    }

    public function getProfilsAbonnees(User $user)
    {
        return $user->profilsSuivre;
    }

    public function emailAnniversaireDeces()
    {
        //$profils = $this->repository->getProfilWhoDiedNow();
        $profil = $this->getProfilById(1);
        $nbre = 12;
        $image = $this->generalService->mergeImageWithText(explode("|", $profil->photometa)[0] ? explode("|", $profil->photometa)[0] : "public/photo-profiles/default.jpg", $nbre." ANS DEJA");
        Notification::send($profil->user, new AnniversaireDeces($profil,$image));
        dd("Sendd....");
    }

    public function supprimerDansGenealogie($id)
    {
        $profils = $this->getAllProfils("asc");
        foreach ($profils as $profil){
            $replace = str_replace($id,"",$profil->genealogie);
            $replace = str_replace(":,",":",$replace);
            $replace = str_replace(",,",",",$replace);
            $profil->genealogie = $replace;
            $profil->save();
        }
    }

    public function updateBiography(Request $request)
    {
        $profil = $this->getProfilById($request->input('id'));
        $profil->biographie = $request->input('biographie');
        $profil->save();
    }

    public function updateGenealogie(Request $request)
    {
        $pere = is_array($request->input('nomPereNumber')) == false ? ($request->input('nomPereNumber') == null ? "" : $request->input('nomPereNumber')) : implode(",", $request->input('nomPereNumber'));
        $mere = is_array($request->input('nomMereNumber')) == false ? ($request->input('nomMereNumber') == null ? "" : $request->input('nomMereNumber')) : implode(",", $request->input('nomMereNumber'));
        $freres = is_array($request->input('nomFreresNumber')) == false ? ($request->input('nomFreresNumber') == null ? "" : $request->input('nomFreresNumber')) : implode(",", $request->input('nomFreresNumber'));
        $soeurs = is_array($request->input('nomSoeursNumber')) == false ? ($request->input('nomSoeursNumber') == null ? "" : $request->input('nomSoeursNumber')) : implode(",", $request->input('nomSoeursNumber'));
        $conjointH = is_array($request->input('nomCHNumber')) == false ? ($request->input('nomCHNumber') == null ? "" : $request->input('nomCHNumber')) : implode(",", $request->input('nomCHNumber'));
        $conjointF = is_array($request->input('nomCFNumber')) == false ? ($request->input('nomCFNumber') == null ? "" : $request->input('nomCFNumber')) : implode(",", $request->input('nomCFNumber'));
        $genealogie = "P:" . $pere . "|M:" . $mere . "|F:" . $freres . "|S:" . $soeurs . "|CH:" . $conjointH . "|CF:" . $conjointF . "|E:";
        $tempPere = explode(',', $pere);
        $tempMere = explode(',', $mere);
        $tempFrere = explode(',', $freres);
        $tempSoeur = explode(',', $soeurs);
        $tempConjointH = explode(',', $conjointH);
        $tempConjointF = explode(',', $conjointF);
        $reponse = array();
        $reponse[0] = $tempPere;
        $reponse[1] = $tempMere;
        $reponse[2] = $tempFrere;
        $reponse[3] = $tempSoeur;
        $reponse[4] = $tempConjointH;
        $reponse[5] = $tempConjointF;
        $profil = $this->getProfilById($request->input('id'));
        $genealogieTemp = $profil->genealogie;
        $enfant = explode('|E:', $genealogieTemp)[1];
        $genealogie = $genealogie . $enfant;
        $profil->genealogie = $genealogie;
        $profil->save();
        $i = 0;
        foreach ($reponse as $tempNow) {
            foreach ($tempNow as $t) {
                switch ($i) {
                    case 0:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 1:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "child");
                        break;
                    case 2:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "brother");
                        break;
                    case 3:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "sister");
                        break;
                    case 4:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "wife");
                        break;
                    case 5:
                        if (empty($t) == false && $this->isCheckGenealogie($profil->id, $t) == true) $this->saveCheckGenealogie($t, $profil->id, "husband");
                        break;
                }
            }
            $i++;
        }
        return $profil;
    }

    public function dedicace(Request $request)
    {
        $bougie = new Bougie();
        $bougie->message = $request->input('message');
        $bougie->nom = $request->input('nom');
        $bougie->profil_id = $request->input('profil');
        if (Auth::check()) {
            if (Auth::user()->email == $bougie->profil->user->email) {
                $bougie->flushEventListeners();
            }
        }
        $this->bougieRepository->save($bougie);
    }

    public function estEgalAuProfil(Request $request)
    {
        $reponse = array();
        $profils = $this->getAllProfils("DESC");
        $prenoms = $this->concatWords(' ', $request->input('prenom1'), $request->input('prenom2'), $request->input('prenom3'), $request->input('prenom4'), $request->input('prenom5'), $request->input('prenom6'), $request->input('prenom7'), $request->input('prenom8'), $request->input('prenom9'), $request->input('prenom10'));
        $profil = new Profil();
        $profil->nom = $request->input('nom');
        $profil->prenoms = $prenoms;
        $profil->sexe = $request->input('sexe');
        $profil->dateDeces = new Carbon($request->input('dateDeces'));
        $profil->dateNaissance = $request->input('dateNaissance') == null ? null : new Carbon($request->input('dateNaissance'));
        $profil->nomDeJeuneFille = $request->input('nomDeJeuneFille');
        foreach ($profils as $p)
        {
            $test = $this->estIdentique($profil,$p);
            if($test == true){
                $reponse[] = $p;
            }
        }
        return $reponse;
    }

    public function estIdentique(Profil $profil,Profil $profil1)
    {
        $reponse = false;
        if (strcasecmp($profil->nom, $profil1->nom) == 0 && strcasecmp($profil->prenoms, $profil1->prenoms) == 0 && strcasecmp($profil->sexe, $profil1->sexe) == 0 && strcasecmp($profil->nomDeJeuneFille, $profil1->nomDeJeuneFille) == 0 && strcasecmp(Carbon::parse($profil->dateDeces)->format("Y-m-d"), $profil1->dateDeces) == 0 && strcasecmp(Carbon::parse($profil->dateNaissance)->format("Y-m-d"), $profil1->dateNaissance) == 0) {
            $reponse = true;
        }
        return $reponse;
    }

    public function contacterRaphael(Request $request)
    {
        $nousContacter = new NousContacter();
        $nousContacter->nom = $request->input("nom");
        $nousContacter->prenom = $request->input("prenom");
        $nousContacter->objet = $request->input("objet");
        $nousContacter->tel = $request->input("tel");
        $nousContacter->email = $request->input("email");
        $nousContacter->message = $request->input("message");
        $user = User::find(2);
        Notification::send($user, new NousContacterNotification($nousContacter));
    }
}
