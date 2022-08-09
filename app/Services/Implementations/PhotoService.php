<?php


namespace App\Services\Implementations;


use App\Models\Monument;
use App\Models\Photo;
use App\Repositories\IPhotoRepository;
use App\Services\IGeneralService;
use App\Services\IPhotoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PhotoService implements IPhotoService
{
    public $repository;
    private $generalService;

    public function __construct(IPhotoRepository $photoRepository, IGeneralService $generalService)
    {
        $this->repository = $photoRepository;
        $this->generalService = $generalService;
    }

    private function validatorPhoto(array $data)
    {
        return Validator::make($data,
            [
                'photos' => 'required|max:200',
                'photos.*' => 'mimes:jpg,jpeg,png',
                'commentaires' => 'required|max:100',
                'dateDuPhoto' => 'nullable|date|before_or_equal:' . date('d-m-Y'),
                'nomDesGens' => 'max:255',
                'auteur' => 'required|max:200'
            ]
        );
    }

    public function save(Request $request)
    {
        $this->validatorPhoto($request->all())->validate();
        $images = $this->generalService->uploadImagesAutre('/photo-to-profile/', $request->file('photos'));
        $photo = new Photo();
        $photo->image = $images;
        $photo->profil_id = $request->input('profil');
        $photo->nom = $request->input('nom');
        $photo->email = $request->input('email');
        $photo->commentaires = $request->input('commentaires');
        $photo->dateDuPhoto = $request->input('dateDuPhoto');
        $photo->nomDesGens = $request->input('nomDesGens');
        $this->repository->save($photo);
        return $photo;
    }

    public function delete(Photo $photo)
    {
        return $photo->delete();
    }

    public function getPhotoById($id)
    {
        return $this->repository->getPhotoById($id);
    }

    private function validatorMonuments(array $data)
    {
        return Validator::make($data,
            [
                'monuments' => 'required|max:200',
                'monuments.*' => 'mimes:jpg,jpeg,png',
                'titreDuMonument' => 'required|max:255',
                'adresseDuMonument' => 'max:255',
            ]
        );
    }

    public function saveMonuments(Request $request)
    {
        $this->validatorMonuments($request->all())->validate();
        $images = $this->generalService->uploadImagesAutre('/photo-monuments/', $request->file('monuments'));
        $photo = new Monument();
        $photo->images = $images;
        $photo->profil_id = $request->input('profil');
        $photo->titreDuMonument = $request->input('titreDuMonument');
        $photo->adresseDuMonument = $request->input('adresseDuMonument');
        $this->repository->saveMonuments($photo);
        return $photo;
    }

    public function getPhotosWhereValidate($choice)
    {
        return $this->repository->getPhotosWhereValidate($choice);
    }

    private function validatorUpdatePhoto(array $data)
    {
        return Validator::make($data,
            [
                'photos' => 'max:200',
                'photos.*' => 'mimes:jpg,jpeg,png',
                'commentaires' => 'required|max:100',
                'dateDuPhoto' => 'nullable|date|before_or_equal:' . date('d-m-Y'),
                'nomDesGens' => 'max:255'
            ]
        );
    }
    public function update(Request $request, Photo $photo)
    {
        $this->validatorUpdatePhoto($request->all())->validate();
        //$images = $this->generalService->uploadImagesAutre('/photo-to-profile/', $request->file('photos'));
        //$photo->image = $images;
        $photo->nom = $request->input('nom');
        $photo->email = $request->input('email');
        $photo->commentaires = $request->input('commentaires');
        $photo->dateDuPhoto = $request->input('dateDuPhoto');
        $photo->nomDesGens = $request->input('nomDesGens');
        $photo->save();
    }
}
