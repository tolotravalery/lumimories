<?php


namespace App\Repositories;


use App\Models\Monument;
use App\Models\Photo;
use App\Models\Profil;

interface IPhotoRepository
{
    public function save(Photo $photo);

    public function mesPhotosValide(Profil $profil);

    public function getPhotoById($id);

    public function saveMonuments(Monument $photo);

    public function getPhotosWhereValidate($choice);
}
