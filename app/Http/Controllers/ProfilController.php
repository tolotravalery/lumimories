<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use App\Models\Profil;
use App\Services\IProfilService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProfilController extends Controller
{
    private $profilService;
    public function __construct(IProfilService $profilService){
        $this->profilService = $profilService;
    }

    public function index()
    {
        $profils = $this->profilService->getAllProfils('DESC');
        $genealogies = [];
        foreach ($profils as $profil){
            $genealogies[] = $this->profilService->getFamilyByProfil($profil)[0];
        }
        return view("admin.profils.list")->with(compact('profils','genealogies'));
    }

    public function show($id)
    {
        $profil = $this->profilService->getProfilById($id);
        if ($profil == null) {
            return redirect(url('/404-not-found'));
        }
        $profils = $this->profilService->getFamilyByProfil($profil)[0];
        $gene = $this->profilService->getFamilyByProfil($profil)[1];
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
        return view("admin.profils.afficher-un")->with(compact('profil', 'profils', 'gene'));
    }

    public function checkValidation(Request $request)
    {
        $this->profilService->checkValidation($request);
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/profils'))->with(compact('message'));
    }

    public function validationAnecdote(Request $request)
    {
        $profil = $this->profilService->getProfilById($request->input('id'));
        foreach ($profil->anecdotes as $p) {
            $p->valider = false;
            $p->save();
        }
        $ids = $request->input('ids');
        if ($ids == null) {
            return redirect(url('admin/profils/' . $profil->id));
        }
        $anecdotes = Anecdote::whereIn('id', $ids)->orderBy('id', 'DESC')->get();
        if (count($anecdotes) == 0) {
            $message = "Aucun information";
            session()->flash('message', $message);
            session()->flash('css', 'text-danger');
            return redirect(url('admin/profils/' . $profil->id))->with(compact('message', 'css'));
        }
        foreach ($anecdotes as $a) {
            $a->valider = true;
            $a->save();
        }
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/profils/' . $profil->id))->with(compact('message', 'css'));
    }

}
