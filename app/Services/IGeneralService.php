<?php

namespace App\Services;

use App\Models\Bougie;
use Illuminate\Http\Request;

interface IGeneralService
{
    public function uploadImages($publicPath, $files);

    public function uploadImagesProfil($name, $publicPath, $files);

    public function uploadImagesAutre($publicPath, $files);

    public function mergeImages($imageA, $imageB);

    public function countMustReturn($limit, $nbreInputs);

    public function paginate($items, $perPage = 5, $page = null);

    public function mergeImageWithText($image,$text);

    public function imageAnniversaire($image,$imageB,$text);
}
