<?php

namespace App\Repositories;

use App\Models\Checkgenealogie;
use App\Models\Contact;
use App\Models\Monument;
use App\Models\Profil;
use App\Models\Signaler;

interface IProfilRepository
{
    public function save(Profil $profil);

    public function getRecentProfil($nombre);

    public function getProfilWhoDiedNow($paginate = null);

    public function getProfilByUser($user, $paginate = null);

    public function getProfilById($id);

    public function getProfilsById($list_id);

    public function findProfils($q, $sexe, $paginate);

    public function findProfilsByNameAndSexe($term, $sexe);

    public function findProfilsByName($term);

    public function getCheckGenealogiesById($list_id);

    public function getProfilsByNameAndFirstName($arrayNoms, $arrayPrenoms);

    public function saveCheckGenealogie($profil, $profil_value, $status);

    public function isCheckGenealogie($profil, $profil_value);

    public function saveSignaler(Signaler $signaler);

    public function saveMonument(Monument $monument);

    public function getProfils();

    public function nbreBougieTotal();

    public function getPreviousOrNext($id, $comparaison, $name, $order);

    public function saveContact(Contact $contact);

    public function findProfilsExtra($q, $sexe, $ville, $religion, $paginate);

    public function getAllProfils($order);

}
