<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use App\Models\Bougie;
use App\Models\Checkgenealogie;
use App\Models\Photo;
use App\Models\Profil;
use App\Models\User;
use App\Services\IAnecdoteService;
use App\Services\IGeneralService;
use App\Services\IPhotoService;
use App\Services\IProfilService;
use App\Services\IUserService;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Foundation\Auth\AuthenticatesUsersOther;
use Illuminate\Foundation\Auth\RegistersUsersOther;
use Illuminate\Foundation\Auth\SendsPasswordResetEmailsOther;
use Illuminate\Http\Request;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class FrontController extends BaseController
{
    use AuthenticatesUsersOther, RegistersUsersOther {
        AuthenticatesUsersOther::guard insteadof RegistersUsersOther;
        AuthenticatesUsersOther::redirectPath insteadof RegistersUsersOther;
    }
    private $profilService;
    private $anecdoteService;
    private $photoService;
    private $userService;
    private $generalService;
    private $allPays = array("Afghanistan", "Afrique_Centrale", "Afrique_du_sud", "Albanie", "Algerie", "Allemagne", "Andorre", "Angola", "Anguilla", "Arabie_Saoudite", "Argentine", "Armenie", "Australie", "Autriche", "Azerbaidjan", "Bahamas", "Bangladesh", "Barbade", "Bahrein", "Belgique", "Belize", "Benin", "Bermudes", "Bielorussie", "Bolivie", "Botswana", "Bhoutan", "Boznie_Herzegovine", "Bresil", "Brunei", "Bulgarie", "Burkina_Faso", "Burundi", "Caiman", "Cambodge", "Cameroun", "Canada", "Canaries", "Cap_vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", "Congo_democratique", "Cook", "Coree_du_Nord", "Coree_du_Sud", "Costa_Rica", "Cote_d_Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", "Dominique", "Egypte", "Emirats_Arabes_Unis", "Equateur", "Erythree", "Espagne", "Estonie", "Etats_Unis", "Ethiopie", "Falkland", "Feroe", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Georgie", "Ghana", "Gibraltar", "Grece", "Grenade", "Groenland", "Guadeloupe", "Guam", "Guatemala", "Guernesey", "Guinee", "Guinee_Bissau", "Guinee equatoriale", "Guyana", "Guyane_Francaise", "Haiti", "Hawaii", "Honduras", "Hong_Kong", "Hongrie", "Inde", "Indonesie", "Iran", "Iraq", "Irlande", "Islande", "Israel", "Italie", "Jamaique", "Jan Mayen", "Japon", "Jersey", "Jordanie", "Kazakhstan", "Kenya", "Kirghizstan", "Kiribati", "Koweit", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Liechtenstein", "Lituanie", "Luxembourg", "Lybie", "Macao", "Macedoine", "Madagascar", "Madère", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", "Man", "Mariannes du Nord", "Maroc", "Marshall", "Martinique", "Maurice", "Mauritanie", "Mayotte", "Mexique", "Micronesie", "Midway", "Moldavie", "Monaco", "Mongolie", "Montserrat", "Mozambique", "Namibie", "Nauru", "Nepal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk", "Norvege", "Nouvelle_Caledonie", "Nouvelle_Zelande", "Oman", "Ouganda", "Ouzbekistan", "Pakistan", "Palau", "Palestine", "Panama", "Papouasie_Nouvelle_Guinee", "Paraguay", "Pays_Bas", "Perou", "Philippines", "Pologne", "Polynesie", "Porto_Rico", "Portugal", "Qatar", "Republique_Dominicaine", "Republique_Tcheque", "Reunion", "Roumanie", "Royaume_Uni", "Russie", "Rwanda", "Sahara Occidental", "Sainte_Lucie", "Saint_Marin", "Salomon", "Salvador", "Samoa_Occidentales", "Samoa_Americaine", "Sao_Tome_et_Principe", "Senegal", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovenie", "Somalie", "Soudan", "Sri_Lanka", "Suede", "Suisse", "Surinam", "Swaziland", "Syrie", "Tadjikistan", "Taiwan", "Tonga", "Tanzanie", "Tchad", "Thailande", "Tibet", "Timor_Oriental", "Togo", "Trinite_et_Tobago", "Tristan da cunha", "Tunisie", "Turkmenistan", "Turquie", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Vierges_Americaines", "Vierges_Britanniques", "Vietnam", "Wake", "Wallis et Futuma", "Yemen", "Yougoslavie", "Zambie", "Zimbabwe");

    public function __construct(IProfilService $profilService, IAnecdoteService $anecdoteService, IPhotoService $photoService, IUserService $userService, IGeneralService $generalService)
    {
        $this->profilService = $profilService;
        $this->anecdoteService = $anecdoteService;
        $this->photoService = $photoService;
        $this->userService = $userService;
        $this->generalService = $generalService;
    }

    protected $redirectTo = '/ok-profil';

    public function monCompte()
    {
        $this->seo("Mon compte", "Lumimories", "Lumimories");
        return view('mon-compte');
    }

    public function monComptePost(Request $request)
    {
        $user = $this->userService->update($request);
        return redirect(url('/mon-compte'));
    }

    public function mesProches()
    {
        $user = Auth::user();
        $profilsByUser = $this->profilService->getProfilByUser($user);
        $profilsAbonnees = $this->profilService->getProfilsAbonnees($user);
        $profil = array();
        foreach ($profilsAbonnees as $p) {
            $p->operation = false;
            $profil[] = $p;
        }
        foreach ($profilsByUser as $p) {
            $p->operation = true;
            $profil[] = $p;
        }
        $profils = $this->generalService->paginate($profil, 10);
        $this->seo();
        return view('list-mes-proches')->with(compact('profils'));
    }

    public function index()
    {
        //$profils = $this->profilService->getRecentProfil(5);
        $profils = $this->profilService->getProfilWhoDiedNow(5);
        $this->seo("Lumimories", "Lumimories", "Lumimories", asset('/public/front/img/logo.png'));
        return view('index')->with(compact('profils'));
    }

    public function listProfilWhoDiedNow()
    {
        $profils = $this->profilService->getProfilWhoDiedNow(8);
        $this->seo();
        return view('list-4')->with(compact('profils'));
    }

    public function detail($id)
    {
        $profil = $this->profilService->getProfilById($id);
        if ($profil == null) {
            return redirect(url('/404-not-found'));
        }
        $systeme = __('website.follow');
        if (Auth::check()) {
            $user = Auth::user();
            $isHere = false;
            foreach ($user->profilsSuivre as $p) {
                if ($profil->id == $p->id) $isHere = true;
            }
            $systeme = $isHere == true ? __('website.subscriber') : __('website.follow');
        }
        $profils = $this->profilService->getFamilyByProfil($profil)[0];
        $mesPhotos = $this->profilService->mesPhotosValide($profil);
        $gene = $this->profilService->getFamilyByProfil($profil)[1];
        $adjectifs = $this->profilService->getFamilyByProfil($profil)[2];
        $pere = "";
        $mere = "";
        $i = 0;
        foreach ($gene as $g) {
            if ($g == __("website.father")) $pere = $profils[$i];
            $i++;
        }
        $i = 0;
        foreach ($gene as $g) {
            if ($g == __("website.mother")) $mere = $profils[$i];
            $i++;
        }
        $this->profilService->visit($profil);
        $metaImage = explode("|", $profil->photometa)[0] ? asset(explode("|", $profil->photometa)[0]) : asset("/public/photo-profiles/default.jpg");
        if(Carbon::parse($profil->dateDeces)->format('d') == Carbon::today()->day && Carbon::parse($profil->dateDeces)->format('m') == Carbon::today()->month){
            $metaImage = asset($profil->photoanniveraire);
        }
        //$this->seo('Allumez une bougie pour ' . $profil->nomFirstProfil(), "Que son âme repose en paix", "Lumimories," . $profil->nomFirstProfil(), explode("|", $profil->photometa)[0] ? asset(explode("|", $profil->photometa)[0]) : asset("/public/photo-profiles/default.jpg"));
        $this->seo($profil->nomFirstProfil(), __("website.meta-description-detail"), "Lumimories," . $profil->nomFirstProfil(), $metaImage);
        return view('detail')->with(compact('profils', 'profil', 'gene', 'systeme', 'adjectifs', 'pere', 'mere', 'mesPhotos'));
    }

    public function ajoutProfil()
    {
        $pays = $this->allPays;
        $this->seo("Lumimories - " . __('website.register-a-loved-one'), "Lumimories", "Lumimories," . __('website.register-a-loved-one') . "," . __('website.register-a-loved-one') . "," . __('website.add') . "," . __('website.profile'), "");
        return view('ajout-profil')->with(compact('pays'));
    }

    public function soumettreProfil(Request $request)
    {
        $message = "";
        $user = $request->input('user') == null ? null : $this->userService->getUserById($request->input('user'));
        if ($user == null) {
            $this->profilService->validatorProfil($request->all())->validate();
            $validator = Validator::make($request->all(), [
            ]);
            $userTemp = $this->userService->getUserByEmail($request->input("email"));
            if ($userTemp != null) {
                if (Hash::check($request->input("password"), $userTemp->password) == true) {
                    $user = $userTemp;
                } else {
                    $validator->errors()->add('password', Lang::get('validation-inline.password'));
                    return redirect('/ajout-profil')->withErrors($validator)->withInput();
                }
            } else {
                $userNew = new User();
                $userNew->email = $request->input('email');
                $userNew->password = $request->input('password');
                $userNew->name = $request->input('nomUtilisateur');
                $userNew->prenom = $request->input('prenomUtilisateur');
                $user = $this->userService->save($userNew);
                $message = __('website.check-your-email');
                $this->register($request, $user);
            }
            $this->login($request);
        } else {
            $this->profilService->validatorProfilUserConnected($request->all())->validate();
            $validator = Validator::make($request->all(), [
            ]);
        }
        $estEgale = $this->profilService->estEgalAuProfil($request);
        if($estEgale!= null){
            session()->flash('message', __('website.profile-exists'));
            session()->flash('estEgale', $estEgale);
            //return redirect('/ajout-profil')->withErrors($validator)->withInput();
            return redirect('/profils-similaires')->withErrors($validator)->withInput();
        }
        else{
            $profil = $this->profilService->save($request, $user);
            session()->flash('message', $message);
            return redirect(url('/ok-profil/' . $profil->id))->with(compact('message'));
        }
    }

    public function profilsSimilaires()
    {
        $this->seo();
        return view('list-profils-similaires');
    }
    public function okProfil($id)
    {
        $this->seo();
        $profil = $this->profilService->getProfilById($id);
        $nom = $profil->nomFirstProfil();
        return view("ok-profil")->with(compact('id', 'nom'));
    }

    public function ok()
    {
        $this->seo();
        return view("ok");
    }

    public function soumettreAnecdote(Request $request)
    {
        $anecdote = $this->anecdoteService->save($request);
        $message = __('website.successful-operation');
        session()->flash('message', $message);
        return redirect(url('/detail/' . $request->input('profil')));
    }

    public function detailAnecdote($id)
    {
        $anecdote = $this->anecdoteService->getAnecdoteById($id);
        if ($anecdote == null) {
            return redirect(url('/404-not-found'));
        }
        $this->seo("Lumimories - Anecdote", "Lumimories", "Lumimories,Anecdote", "");
        return view('detail-anecdote')->with(compact('anecdote'));
    }

    public function notfound()
    {
        $this->seo("Lumimories - 404", "Lumimories", "", "");
        return view('errors.404');
    }

    public function allumerBougie(Request $request)
    {
        $this->profilService->allumerBougie($request);
        sleep(5);
        return response()->json(['success' => $this->profilService->nbreBougieTotal()]);
    }

    public function dedicace(Request $request)
    {
        $this->profilService->dedicace($request);
        sleep(5);
        return response()->json(['success' => $this->profilService->nbreBougieTotal()]);
    }

    public function allumerBougieGeneral(Request $request)
    {
        $this->profilService->allumerBougieGeneral($request);
        sleep(5);
        return response()->json(['success' => $this->profilService->nbreBougieTotal()]);
    }

    public function rechercher(Request $request)
    {
        $q = $request->input('q');
        $sexe = $request->input('sexe');
        $profils = $this->profilService->findProfils($request, 15);
        $message = __("website.not-found-search");
        if (count($profils) > 0) $message = "";
        session()->flash('message', $message);
        $profil = null;
        //$nbres = $this->profilService->nbreProfil();
        $this->seo("Lumimories - Recherche", "Lumimories", "Lumimories,Recherche", "");
        return view('list')->with(compact('profil', 'profils', 'q', 'message', 'sexe'));
    }

    public function rechercherProfil(Request $request)
    {
        $q = $request->input('q');
        $sexe = $request->input('sexe');
        $ville = $request->input('ville');
        $religion = $request->input('religion');
        $profils = $this->profilService->findProfilsExtra($request, 15);
        $message = __("website.not-found-search");
        if (count($profils) > 0) $message = "";
        session()->flash('message', $message);
        $profil = null;
        //$nbres = $this->profilService->nbreProfil();
        $this->seo("Lumimories - Recherche", "Lumimories", "Lumimories,Recherche", "");
        return view('list')->with(compact('profil', 'profils', 'q', 'message', 'sexe', 'ville', 'religion'));
    }

    public function editProfil($id)
    {
        $pays = $this->allPays;
        $profil = $this->profilService->getProfilById($id);
        $prenoms = $this->profilService->splitWords(' ', $profil->prenoms);
        $surnoms = $this->profilService->splitWords(' ', $profil->surnom);
        $villesHabitees = $this->profilService->splitWords(', ', $profil->villesHabitees);
        $genealogie = $this->profilService->getFamilyByProfilInEdit($profil);
        $this->seo("Lumimories - Edit profil - " . $profil->prenoms . " " . $profil->nom, "Lumimories Edit profil", "Lumimories,Edit,profil", explode("|", $profil->photoProfil)[0] ? asset(explode("|", $profil->photoProfil)[0]) : asset("/public/photo-profiles/default.jpg"));
        return view('edit-profil')->with(compact('profil', 'pays', 'genealogie', 'prenoms', 'villesHabitees', 'surnoms'));
    }

    public function modifierProfil(Request $request)
    {
        $profil = $this->profilService->getProfilById($request->input('id'));
        $message = "";
        $css = "";
        $user = $request->input('user') == null ? null : $this->userService->getUserById($request->input('user'));
        if ($user == null) {
            $this->profilService->validatorProfil($request->all())->validate();
            $validator = Validator::make($request->all(), [
            ]);
            $user = null;
            $userTemp = $this->userService->getUserByEmail($request->input("email"));
            if ($userTemp != null) {
                if (Hash::check($request->input("password"), $userTemp->password) == true) {
                    $user = $userTemp;
                } else {
                    $validator->errors()->add('password', Lang::get('validation-inline.password'));
                    return redirect('/edit-profil/' . $profil->id)->withErrors($validator)->withInput();
                }
            }
            if ($user->id != $profil->user->id) {
                $message = "vous ne pouvez pas editer ce profil";
                $css = "danger";
                session()->flash('message', $message);
                session()->flash('css', $css);
                return redirect(url('/edit-profil/' . $profil->id));
            }
        } else {
            $this->profilService->validatorProfilUserConnected($request->all())->validate();
            $validator = Validator::make($request->all(), [
            ]);
            if ($user->id != $profil->user->id) {
                $message = "vous ne pouvez pas editer ce profil";
                $css = "danger";
                session()->flash('message', $message);
                session()->flash('css', $css);
                return redirect(url('/edit-profil/' . $profil->id));
            }
        }

        $profil = $this->profilService->update($request);
        $message = "Modification réussie";
        $css = "success";
        session()->flash('message', $message);
        session()->flash('css', $css);
        return redirect(url('/ok-profil/' . $profil->id))->with(compact('message'));
    }

    public function loginFront($url = null)
    {
        $this->seo("Lumimories - Login", "Login Lumimories", "Login, Se connecter, Lumimories", "");
        return view('login')->with(compact('url'));
    }

    public function registerFront($url = null)
    {
        $this->seo("Lumimories - Register", "Register Lumimories", "Register, S'inscrire ', Lumimories", "");
        return view('register')->with(compact('url'));
    }

    public function loginPostFront(Request $request)
    {
        $redirect = $this->login($request);
        $redirect = $redirect == url('/ok-profil') ? url('/' . $request->input("url")) : $redirect;
        return redirect(url($redirect));
    }

    public function validator(array $data)
    {
        return Validator::make($data,
            [
                'email' => 'required|email|unique:users',
            ]
        );
    }

    public function validatorRegister(array $data)
    {
        return Validator::make($data,
            [
                'email' => 'required|email|unique:users|confirmed',
                'password' => 'required|min:8',
            ]
        );
    }

    public function registerPostFront(Request $request)
    {
        $this->validatorRegister($request->all())->validate();
        $u = new User();
        $u->email = $request->input('email');
        $u->password = $request->input('password');
        $u->name = $request->input('name');
        $u->prenom = $request->input('prenom');
        $user = $this->userService->save($u);
        $message = __('website.message-link');
        $this->register($request, $user);
        session()->flash('message', $message);
        session()->flash('userName', $user->name . " " . $u->prenom);
        return redirect(url('/ok'))->with(compact('message'));
    }

    public function ajoutPhotos($id)
    {
        $profil = $this->profilService->getProfilById($id);
        if ($profil == null) {
            return redirect(url('/404-not-found'));
        }
        $this->seo("Lumimories - Ajout Photo", "Ajout photo", "photo, Lumimories", "");
        return view('ajout-photo')->with(compact('profil'));
    }

    public function soumettrePhotos(Request $request)
    {
        $photos = $this->photoService->save($request);
        $message = __('website.successful-operation');
        session()->flash('message-photo', $message);
        return redirect(url('/detail/' . $photos->profil_id));

    }

    public function soumettreMonument(Request $request)
    {
        $monuments = $this->photoService->saveMonuments($request);
        $message = __('website.successful-operation');
        session()->flash('message-monument', $message);
        return redirect(url('/detail/' . $monuments->profil_id));

    }

    public function recherchePersonnes(Request $request)
    {
        return $this->profilService->findProfilsByNameAndSexe($request->input('term'), $request->input('sexe'));
    }

    public function recherchePersonnesAutre(Request $request)
    {
        return $this->profilService->findProfilsByName($request->input('term'));
    }

    public function checkGenealogie(Request $request)
    {
        $checks = $this->profilService->getCheckGenealogiesById($request->input('ids'));
        return redirect(url('/detail/' . $request->input('profil')));
    }

    public function suivre(Request $request)
    {
        $user = Auth::user();
        $profil = $this->profilService->getProfilById($request->input('profil'));
        $this->profilService->suivre($profil, $user);
        $message = __('website.successful-operation');
        session()->flash('message-suivre', $message);
        return redirect(url('/detail/' . $profil->id));
    }

    public function signaler(Request $request)
    {
        $this->profilService->signaler($request);
        $message = __('website.successful-operation');
        session()->flash('message-suivre', $message);
        return redirect(url('/detail/' . $request->input('profil')));
    }

    public function signalerAnecdote(Request $request)
    {
        $this->anecdoteService->signaler($request);
        $message = __('website.successful-operation');
        session()->flash('message-suivre', $message);
        return redirect(url('/detail/' . $request->input('profil')));
    }

    public function bougieDeMemoire()
    {
        $count = $this->profilService->nbreBougieTotal();
        $this->seo("Lumimories - Bougie de mémoire", "Bougie de mémoire", "lumimories, bougie", "");
        return view('bougie-de-memoire')->with(compact('count'));
    }

    public function testImage()
    {
        $profils = $this->profilService->getAllProfils('DESC');
        foreach ($profils as $profil) {
            $image = explode("|", $profil->photoProfil)[0] ? explode("|", $profil->photoProfil)[0] : "public/photo-profiles/default.jpg";
            if (strcmp($image, "public/photo-profiles/default.jpg") != 0) echo $this->generalService->mergeImages($image, 'public/front/img/bougie-removebg-preview.png') . "<br/>";
        }
    }

    public function previous(Request $request)
    {
        $profil = $this->profilService->getPreviousOrNext($request->input('id'), '<', $request->input('nom'), 'DESC');
        if ($profil != null) return redirect(url('/detail/' . $profil->id));
        else return redirect(url('/detail/' . $request->input('id')));
    }

    public function next(Request $request)
    {
        $profil = $this->profilService->getPreviousOrNext($request->input('id'), '>', $request->input('nom'), 'ASC');
        if ($profil != null) return redirect(url('/detail/' . $profil->id));
        else return redirect(url('/detail/' . $request->input('id')));
    }

    public function supprimerPhoto($id)
    {
        $photo = $this->photoService->getPhotoById($id);
        $profil = $photo->profil->id;
        $this->photoService->delete($photo);
        return redirect(url('/detail/' . $profil));
    }

    public function supprimerAnectode($id)
    {
        $anecdote = $this->anecdoteService->getAnecdoteById($id);
        $profil = $anecdote->profil->id;
        $this->anecdoteService->delete($anecdote);
        return redirect(url('/detail/' . $profil));
    }

    public function modifierAnecdote(Request $request)
    {
        $anecdote = $this->anecdoteService->getAnecdoteById($request->input('id'));
        $this->anecdoteService->update($request, $anecdote);
        $profil = $anecdote->profil->id;
        return redirect(url('/detail/' . $profil));
    }

    public function modifierPhoto(Request $request)
    {
        $photo = $this->photoService->getPhotoById($request->input('id'));
        $this->photoService->update($request, $photo);
        $profil = $photo->profil->id;
        return redirect(url('/detail/' . $profil));
    }

    public function contact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $this->profilService->contacterAdmin($request);
        return response()->json(['success' => 'Message envoyé']);
    }

    public function supprimerProfil($id)
    {
        $this->profilService->deleteProfil($id);
        $message = __('website.successful-operation');
        session()->flash('message', $message);
        return redirect(url('/mes-proches'));
    }

    public function testImageAvecText()
    {
        /*$profil= $this->profilService->getProfilById(28);
        echo mb_convert_encoding(jdtojewish( gregoriantojd(Carbon::parse($profil->dateDeces)->format('m'), Carbon::parse($profil->dateDeces)->format('d'), Carbon::parse($profil->dateDeces)->format('Y')), true, CAL_JEWISH_ADD_GERESHAYIM), "UTF-8", "ISO-8859-8");
        $image = $this->generalService->imageAnniversaire(explode("|",$profil->photoProfil)[0] ?  explode("|",$profil->photoProfil)[0] : "public/photo-profiles/default.jpg",'public/front/img/bougie-removebg-preview.png', mb_convert_encoding(jdtojewish( gregoriantojd(Carbon::parse($profil->dateDeces)->format('m'), Carbon::parse($profil->dateDeces)->format('d'), Carbon::parse($profil->dateDeces)->format('Y')), true, CAL_JEWISH_ADD_GERESHAYIM), "UTF-8", "ISO-8859-8"));*/
    }

    public function editBiographieProfil($id)
    {
        $profil = $this->profilService->getProfilById($id);
        $this->seo();
        return view('edit-biographie')->with(compact('profil'));
    }

    public function modifierBiographie(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'biographie' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $this->profilService->updateBiography($request);
        return response()->json(['success' => __('website.successful-operation')]);
    }

    public function editGenealogie($id)
    {
        $profil = $this->profilService->getProfilById($id);
        $genealogie = $this->profilService->getFamilyByProfilInEdit($profil);
        $this->seo();
        return view('edit-genealogie')->with(compact('profil','genealogie'));
    }

    public function modifierGenealogie(Request $request)
    {
        $profil = $this->profilService->updateGenealogie($request);
        $message = __('website.modification-message');
        session()->flash('message', $message);
        return redirect(url('/detail/' . $profil->id))->with(compact('message'));
    }

    public function nousContacter()
    {
        $this->seo();
        return view('nous-contacter');
    }

    public function envoyerEmailNousContacter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'message' => 'required',
            'objet' => 'required',
            'nom' => 'required',
            'telephone' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()->all()]);
        }
        $this->profilService->contacterRaphael($request);
        return response()->json(['success' => 'Message envoyé']);
    }
}
