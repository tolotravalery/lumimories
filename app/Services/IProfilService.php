<?php

namespace App\Services;

use App\Models\Profil;
use App\Models\User;
use Illuminate\Http\Request;

interface IProfilService
{
    public function save(Request $request, $user);

    public function getRecentProfil($nombre);

    public function getAllProfils($order);

    public function getProfilWhoDiedNow($paginate);

    public function getProfilByUser($user, $paginate = null);

    public function getProfilById($id);

    public function getProfilsById($id);

    public function getFamilyByProfil($profil);

    public function getFamilyByProfilInEdit($profil);

    public function addNombreBougieProfil($id);

    public function allumerBougie(Request $request);

    public function dedicace(Request $request);

    public function allumerBougieGeneral(Request $request);

    public function findProfils(Request $request, $paginate);

    public function findProfilsByNameAndSexe($term, $sexe);

    public function findProfilsByName($term);

    public function getCheckGenealogiesById($list_id);

    public function validatorProfil(array $data);

    public function validatorProfilUserConnected(array $data);

    public function update(Request $request);

    public function suivre(Profil $profil, User $user);

    public function signaler(Request $request);

    public function concatWords($delimiter, ...$words);

    public function splitWords($delimiter, $words);

    public function adjectifPossessifs($genealogie);

    public function nbreBougieTotal();

    public function getPreviousOrNext($id, $comparaison, $name, $order);

    public function mesPhotosValide(Profil $profil);

    public function contacterAdmin(Request $request);

    public function deleteProfil($id);

    public function visit(Profil $profil);

    public function findProfilsExtra(Request $request, $paginate);

    public function nbreProfil();

    public function checkValidation(Request $request);

    public function getProfilsAbonnees(User $user);

    public function emailAnniversaireDeces();

    public function supprimerDansGenealogie($id);

    public function updateBiography(Request $request);

    public function updateGenealogie(Request $request);

    public function estEgalAuProfil(Request $request);

    public function contacterRaphael(Request $request);
}
