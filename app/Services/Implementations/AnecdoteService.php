<?php
namespace App\Services\Implementations;
use App\Models\Anecdote;
use App\Models\SignalerAnecdote;
use App\Repositories\IAnecdoteRepository;
use App\Services\IAnecdoteService;
use App\Services\IGeneralService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnecdoteService implements IAnecdoteService
{
    private $repository;
    private $generalService;
    public function __construct(IAnecdoteRepository $repository, IGeneralService $generalService)
    {
        $this->repository = $repository;
        $this->generalService = $generalService;
    }

    private function validatorAnecdote(array $data)
    {
        return Validator::make($data,
            [
                'avis' => 'required',
                'photos.*' => 'mimes:jpg,jpeg,png',
                'auteur' => 'required',
                'email' => 'required|email',
            ]
        );
    }



    public function save(Request $request)
    {
        $this->validatorAnecdote($request->all())->validate();
        $images = $this->generalService->uploadImages('/photo-anecdotes/', $request->file('photos'));
        $anecdote = new Anecdote();
        $anecdote->avis = $request->input('avis');
        $anecdote->photos = $images;
        $anecdote->profil_id = $request->input('profil');
        $anecdote->auteur =$request->input('auteur');
        $anecdote->email =$request->input('email');
        $this->repository->save($anecdote);
        return $anecdote;
    }

    public function getAnecdoteById($id)
    {
        return $this->repository->getAnecdoteById($id);
    }

    public function delete(Anecdote $anecdote)
    {
        return $anecdote->delete();
    }

    public function update(Request $request, Anecdote $anecdote)
    {
        $this->validatorAnecdote($request->all())->validate();
        $images = $this->generalService->uploadImages('/photo-anecdotes/', $request->file('photos'));
        $anecdote->avis = $request->input('avis');
        $anecdote->photos = $images;
        $anecdote->auteur =$request->input('auteur');
        $anecdote->email =$request->input('email');
        $anecdote->save();
        return $anecdote;
    }

    public function validator(array $data)
    {
        return Validator::make($data,
            [
                'raison' => 'required',
            ]
        );
    }
    public function signaler(Request $request)
    {
        $this->validator($request->all())->validate();
        $signaler = new SignalerAnecdote();
        $signaler->raison = $request->input('raison');
        $signaler->anecdote_id = $request->input('anecdote');
        $this->repository->saveSignaler($signaler);
    }

    public function getAnecdotesWhereValidate($choice)
    {
        return $this->repository->getAnecdotesWhereValidate($choice);
    }
}
