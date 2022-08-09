<?php

namespace App\Http\Controllers;

use App\Models\Anecdote;
use App\Services\IAnecdoteService;
use Illuminate\Http\Request;

class AnecdoteController extends Controller
{
    private $anecdoteService;
    public function __construct(IAnecdoteService $anecdoteService){
        $this->anecdoteService = $anecdoteService;
    }

    public function listValides()
    {
        $title = "Valides";
        $anecdotes = $this->anecdoteService->getAnecdotesWhereValidate(true);
        return view("admin.anecdotes.list")->with(compact('anecdotes', 'title'));
    }

    public function listInValides()
    {
        $title = "Invalides";
        $anecdotes = $this->anecdoteService->getAnecdotesWhereValidate(false);
        return view("admin.anecdotes.list")->with(compact('anecdotes', 'title'));
    }

    public function validationAnecdote(Request $request)
    {
        $ids = $request->input('ids');
        if($ids == null){
            $message = "Aucun ligne sélectionné";
            session()->flash('message', $message);
            session()->flash('css', 'text-danger');
            return redirect(url('admin/anecdotes-invalides'))->with(compact('message','css'));
        }
        $anecdotes = Anecdote::whereIn('id',$ids)->orderBy('id', 'DESC')->get();
        if(count($anecdotes) == 0){
            $message = "Aucun information";
            session()->flash('message', $message);
            session()->flash('css', 'text-danger');
            return redirect(url('admin/anecdotes-invalides'))->with(compact('message','css'));
        }
        foreach ($anecdotes as $a){
            $a->valider = true;
            $a->save();
        }
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/anecdotes-valides'))->with(compact('message','css'));
    }
    public function checkValidation(Request $request)
    {
        $anecdote = Anecdote::find($request->input('id'));
        $request->input('status') == "valide" ?  $anecdote->valider= true :  $anecdote->valider = false;
        $anecdote->save();
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/anecdotes-valides'))->with(compact('message', 'css'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $anecdote= $this->anecdoteService->getAnecdoteById($id);
        $anecdote->delete();
        $message = "Opération réussie";
        session()->flash('message', $message);
        session()->flash('css', 'text-success');
        return redirect(url('admin/anecdotes-valides'))->with(compact('message', 'css'));
    }
}
