<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        $series = Series::all();
        $message = $request->session()->get('message');
        return view('series.index')
            ->with('series', $series)
            ->with('message', $message);


    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesFormRequest $request)
    {
        $series = Series::create($request->all());
        return redirect('/series')
            ->with('message', "Series {$series->name} criada com sucesso!");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Series $series)
    {

        return view('series.edit')
            ->with('series', $series);
    }


    public function update(SeriesFormRequest $request, Series $series)
    {

        $series->fill($request->all());
        $series->save();
        return redirect('/series')
        ->with('message', "Series {$request->name} editada com sucesso!");
    }


    public function destroy(Series $series)
    {
        $series->delete();

        return redirect('/series')
            ->with('message', "Series {$series->name} deletada com sucesso!");


    }
}
