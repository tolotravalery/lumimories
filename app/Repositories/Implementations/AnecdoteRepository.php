<?php
namespace App\Repositories\Implementations;
use App\Models\Anecdote;
use App\Models\SignalerAnecdote;
use App\Repositories\IAnecdoteRepository;

class AnecdoteRepository implements IAnecdoteRepository
{

    public function save(Anecdote $anecdote)
    {
        return Anecdote::create([
            'avis' => $anecdote->avis,
            'photos' => $anecdote->photos,
            'profil_id' => $anecdote->profil_id,
            'auteur' => $anecdote->auteur,
            'email' => $anecdote->email,
            'valider' => true
        ]);
    }

    public function getAnecdoteById($id)
    {
        return Anecdote::findOrFail($id);
    }

    public function saveSignaler(SignalerAnecdote $signaler)
    {
        SignalerAnecdote::create([
            'raison' => $signaler->raison,
            'anecdote_id' => $signaler->anecdote_id,
        ]);

    }

    public function getAnecdotesWhereValidate($choice)
    {
        return Anecdote::where('valider', '=', $choice)->get();
    }
}
