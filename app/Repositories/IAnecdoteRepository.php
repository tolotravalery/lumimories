<?php
namespace App\Repositories;

use App\Models\Anecdote;
use App\Models\SignalerAnecdote;

interface IAnecdoteRepository
{
    public function save(Anecdote $anecdote);

    public function getAnecdoteById($id);

    public function saveSignaler(SignalerAnecdote $signaler);

    public function getAnecdotesWhereValidate($choice);
}
