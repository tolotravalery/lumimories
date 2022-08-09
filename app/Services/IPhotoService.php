<?php


namespace App\Services;


use App\Models\Photo;
use Illuminate\Http\Request;

interface IPhotoService
{
    public function save(Request $request);

    public function delete(Photo $photo);

    public function getPhotoById($id);

    public function saveMonuments(Request $request);

    public function getPhotosWhereValidate($choice);

    public function update(Request $request, Photo $photo);
}
