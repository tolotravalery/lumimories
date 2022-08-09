<?php


namespace App\Repositories\Implementations;


use App\Models\Monument;
use App\Models\Photo;
use App\Models\Profil;
use App\Repositories\IPhotoRepository;

class PhotoRepository implements IPhotoRepository
{

    public function save(Photo $photo)
    {
        return Photo::create([
            'image' => $photo->image,
            'profil_id' => $photo->profil_id,
            'nom' => $photo->nom,
            'email' => $photo->email,
            'valider' => true,
            'commentaires' => $photo->commentaires,
            'dateDuPhoto' => $photo->dateDuPhoto,
            'nomDesGens' => $photo->nomDesGens
        ]);
    }

    public function mesPhotosValide(Profil $profil)
    {
        return Photo::where('valider', '=', true)->where('profil_id','=',$profil->id)->orderBy('id', 'DESC')->get();
    }

    public function getPhotoById($id)
    {
        return Photo::findOrFail($id);
    }

    public function saveMonuments(Monument $photo)
    {
        return Monument::create([
            'images' => $photo->images,
            'profil_id' => $photo->profil_id,
            'titreDuMonument' => $photo->titreDuMonument,
            'adresseDuMonument' => $photo->adresseDuMonument,
        ]);
    }

    public function getPhotosWhereValidate($choice)
    {
        return Photo::where('valider', '=', $choice)->get();
    }
}
