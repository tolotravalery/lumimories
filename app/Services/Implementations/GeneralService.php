<?php

namespace App\Services\Implementations;

use App\Models\Bougie;
use App\Repositories\Implementations\BougieRepository;
use App\Services\IGeneralService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\This;

class GeneralService implements IGeneralService
{
    public function uploadImages($publicPath, $inputFiles)
    {
        $images = array();
        $destinationPath = public_path($publicPath);
        if ($files = $inputFiles) {
            foreach ($files as $file) {
                $name = $file->getClientOriginalName();
                $file->move($destinationPath, $name);
                $images[] = "public" . $publicPath . $name;
            }
        }
        return implode("|", $images);
    }

    public function uploadImagesProfil($name, $publicPath, $inputFiles)
    {
        $images = array();
        $destinationPath = public_path($publicPath);
        $newFiles = array();

        if ($files = $inputFiles) {
            $nbre = $this->countMustReturn(10, count($inputFiles));
            $j = 0;
            $a = 0;
            if ($nbre > 1) {
                for ($i = count($inputFiles) - $nbre; $i < count($inputFiles); $i++) {
                    $newFiles[$j] = $inputFiles[$i];
                    $j++;
                }
            } else {
                foreach ($inputFiles as $file) {
                    $newFiles[0] = $file;
                }
            }
            foreach ($newFiles as $file) {
                $name1 = $name . $a . '.' . $file->getClientOriginalExtension();
                $file->move($destinationPath, $name1);
                $images[] = "public" . $publicPath . $name1;
                $a++;
            }
        }
        return implode("|", $images);
    }

    public function uploadImagesAutre($publicPath, $inputFiles)
    {
        $images = array();
        $destinationPath = public_path($publicPath);
        $newFiles = array();
        if ($files = $inputFiles) {
            $nbre = $this->countMustReturn(10, count($inputFiles));
            $j = 0;
            $a = 0;
            if ($nbre > 1) {
                for ($i = count($inputFiles) - $nbre; $i < count($inputFiles); $i++) {
                    $newFiles[$j] = $inputFiles[$i];
                    $j++;
                }
            } else {
                $newFiles[0] = $inputFiles[1];
            }
            foreach ($newFiles as $file) {
                $name1 = $file->getClientOriginalName();
                $file->move($destinationPath, $name1);
                $images[] = "public" . $publicPath . $name1;
                $a++;
            }
        }
        return implode("|", $images);
    }

    public function resize($imageA, $thumb_w, $thumb_h)
    {
        $image1 = $this->imageCreateFrom($imageA);
        $img_size_arrayA = getimagesize($imageA);
        $merged_image = imagecreatetruecolor($thumb_w, $thumb_h);
        $this->imageCreateFrom($imageA);
        imagecopyresampled($merged_image, $image1, 0, 0, 0, 0, $thumb_w, $thumb_h, $img_size_arrayA[0], $img_size_arrayA[1]);
        $this->imageFrom($merged_image, $imageA);
        imagedestroy($merged_image);
        return $imageA;
    }

    public function mergeImages($imageA, $imageB)
    {
        $imageA = $this->resize($imageA, 626, 626);
        $name = explode('.', $imageA);
        $name = $name[0] . "-meta." . $name[1];
        $image1 = $this->imageCreateFrom($imageA);
        $image2 = $this->imageCreateFrom($imageB);
        $img_size_arrayA = getimagesize($imageA);
        $img_size_arrayB = getimagesize($imageB);

        $merged_image = imagecreatetruecolor($img_size_arrayA[0], $img_size_arrayA[1]);
        $merged_imageB = imagecreatetruecolor($img_size_arrayB[0], $img_size_arrayB[1]);
        imagecopy($merged_image, $image1, 0, 0, 0, 0, $img_size_arrayA[0], $img_size_arrayA[1]);
        $marge_right = $img_size_arrayA[0] - $img_size_arrayB[0] - 10;
        $marge_bottom = $img_size_arrayA[1] - $img_size_arrayB[1] - 10;
        $sx = imagesx($merged_imageB);
        $sy = imagesy($merged_imageB);
        $this->imagecopymerge_alpha($merged_image, $image2, $marge_right, $marge_bottom, 0, 0, $sx, $sy, 60);
        $this->imageFrom($merged_image, $name);
        imagedestroy($merged_image);
        return $name;
    }

    function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct)
    {
        $cut = imagecreatetruecolor($src_w, $src_h);
        imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
        imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
        imagecopymerge($dst_im, $cut, $dst_x, $dst_y, 0, 0, $src_w, $src_h, $pct);
    }

    function imageCreateFrom($image)
    {
        $exploded = explode('.', $image);
        $ext = $exploded[count($exploded) - 1];

        if (preg_match('/jpg|jpeg/i', $ext))
            return imagecreatefromjpeg($image);
        else if (preg_match('/png/i', $ext))
            return imagecreatefrompng($image);
        else if (preg_match('/gif/i', $ext))
            return imagecreatefromgif($image);
        else if (preg_match('/bmp/i', $ext))
            return imagecreatefrombmp($image);
        else
            return 0;
    }

    function imageFrom($merged_image, $image)
    {
        $exploded = explode('.', $image);
        $ext = $exploded[count($exploded) - 1];

        if (preg_match('/jpg|jpeg/i', $ext))
            imagejpeg($merged_image, $image);
        else if (preg_match('/png/i', $ext))
            imagepng($merged_image, $image);
        else if (preg_match('/gif/i', $ext))
            imagegif($merged_image, $image);
        else if (preg_match('/bmp/i', $ext))
            imagebmp($merged_image, $image);
        else
            return 0;
    }


    public function countMustReturn($limit, $nbreInputs)
    {
        $value = 0;
        $input = [];
        for ($i = 1, $j = 1; $i < $limit, $j < $limit; $i++, $j++) {
            if ($i == 1 && $j == 1) {
                $input[$i] = 1;
            } else {
                $input[$i] = $input[$i - 1] + $j;
            }
        }
        for ($i = 1; $i < $limit; $i++) {

            if ($input[$i] == $nbreInputs) {
                $value = $i;
            }
        }
        return $value;
    }


    public function paginate($items, $perPage = 5, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);
    }

    public function mergeImageWithText($image, $text)
    {
        $imageA = $this->resize($image, 350, 350);
        $name = explode('.', $imageA);
        $name = $name[0] . "-anniversary." . $name[1];
        $image1 = $this->imageCreateFrom($imageA);
        $img_size_arrayA = getimagesize($imageA);
        $merged_image = imagecreatetruecolor($img_size_arrayA[0], $img_size_arrayA[1]);
        $color = imagecolorallocate($merged_image, 255, 255, 0);
        imagecopy($merged_image, $image1, 0, 0, 0, 0, $img_size_arrayA[0], $img_size_arrayA[1]);
        /*putenv('GDFONTPATH=' . realpath('.'));*/
        //$font = realpath('./public/front/css/icon_fonts/font/fontello.ttf');
        imagestring($merged_image, 5, 145, 300, $text, $color);
        //imagettftext($merged_image, 20, 0, 10, 20, $color, $font, $text);
        $this->imageFrom($merged_image, $name);
        imagedestroy($merged_image);
        return $name;
    }

    public function imageAnniversaire($image, $imageB, $text)
    {
        $imageAnniversaire = $this->mergeImages($image, $imageB);
        return $this->mergeImageWithText($imageAnniversaire, $text);
    }
}
