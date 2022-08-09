<?php


namespace App\Http\Controllers;


use App\Models\Profil;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

class SitemapController
{
    public function generate_sitemap()
    {
        $sitemap = App::make('sitemap');
        $profils = Profil::orderBy('id', 'DESC')->where('validerParAdmin', '=', true)->get();
        foreach ($profils as $profil) {
            $sitemap->add(url("/detail/".$profil->id), $profil->updated_at, '1.0', 'monthly');
        }
        $sitemap->add(URL::to('/ajout-profil'), date('Y-m-d H:i:s'), '0.9', 'never');
        /*$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
        $sitemap->add(URL::to('/a-propos'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/contact'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/charte-dengagement-qualite'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/recrutement'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/villes/a'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/annuaire-serruriers/a'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/prix'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/diagnostic'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/blogs'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/nos-prestations'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/nos-marques'), date('Y-m-d H:i:s'), '0.9', 'never');
        $sitemap->add(URL::to('/avis'), date('Y-m-d H:i:s'), '0.9', 'never');
        // departements
        $departements= Departement::orderBy('nom','ASC')->get();
        foreach ($departements as $d){
            $sitemap->add(url("/departement/".$d->numero), $d->updated_at, '0.8', 'monthly');
        }
        // villes
        $villes= Ville::orderBy('nom','ASC')->get();
        foreach ($villes as $ville){
            $sitemap->add(url("/d-".$ville->departement->numero."/".$ville->url), $ville->updated_at, '0.8', 'monthly');
        }*/
        $sitemap->store('xml', 'sitemap');
    }
}