<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index(Request $request)
    {
        $series = Serie::all();
        $message = $request->session()->get('message');
        return view('series.index')
            ->with('series', $series)
            ->with('message', $message);


    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $serie = Serie::create($request->all());
        return redirect('/series')
            ->with('message', "Serie {$serie->name} criada com sucesso!");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Serie $series)
    {

        return view('series.edit')
            ->with('series', $series);
    }


    public function update(Request $request, Serie $series)
    {

        $series->fill($request->all());
        $series->save();
        return redirect('/series')
        ->with('message', "Serie {$request->name} editada com sucesso!");
    }


    public function destroy(Serie $series)
    {
        $series->delete();

        return redirect('/series')
            ->with('message', "Serie {$series->name} deletada com sucesso!");


    }
}
