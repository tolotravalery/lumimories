<?php
namespace App\Services;

use App\Models\Anecdote;
use Illuminate\Http\Request;

interface IAnecdoteService
{
    public function save(Request $request);

    public function getAnecdoteById($id);

    public function delete(Anecdote $anecdote);

    public function update(Request $request, Anecdote $anecdote);

    public function signaler(Request $request);

    public function getAnecdotesWhereValidate($choice);
}
