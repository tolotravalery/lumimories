<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Services\IPhotoService;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    private $photoService;

    public function __construct(IPhotoService $photoService)
    {
        $this->photoService = $photoService;
    }

    public function listValides()
    {
        $title = "Valides";
        $photos = $this->photoService->getPhotosWhereValidate(true);
        return view("admin.photos.list")->with(compact('photos', 'title'));
    }

    public function listInValides()
    {
        $title = "Invalides";
        $photos = $this->photoService->getPhotosWhereValidate(false);
        return view("admin.photos.list")->with(compact('photos', 'title'));
    }

    public function validationPhoto(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids == null) {
            $message = "Aucun ligne sélectionné";
            session()->flash('message', $message);
            session()->flash('css', 'text-danger');
            return redirect(url('admin/photos-invalides'))->with(compact('message', 'css'));
        }
        $photos = Photo::whereIn('id', $ids)->orderBy('id', 'DESC')->get();
        if (count($photos) == 0) {
            $message = "Aucun information";
            session()->flash('message', $message);
            session()->flash('css', 'text-danger');
            return redirect(url('admin/photos-invalides'))->with(compact('message', 'css'));
        }
        foreach ($photos as $a) {
            $a->valider = true;
            $a->save();
        }
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/photos-valides'))->with(compact('message', 'css'));
    }

    public function checkValidation(Request $request)
    {
        $photo = Photo::find($request->input('id'));
        $request->input('status') == "valide" ? $photo->valider = true : $photo->valider = false;
        $photo->save();
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/photos-valides'))->with(compact('message', 'css'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $photo = $this->photoService->getPhotoById($id);
        $photo->delete();
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/photos-valides'))->with(compact('message', 'css'));
    }
}
