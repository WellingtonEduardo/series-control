<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
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
        $serie = Series::create($request->all());


        $seasons = [];
        for ($i = 1; $i <= $request->seasonsQty; $i++) {
            $seasons[] = [
                'series_id' => $serie->id,
                'number' => $i,
            ];
        }
        Season::insert($seasons);

        $episodes = [];
        foreach ($serie->seasons as $season) {
            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $episodes[] = [
                    'season_id' => $season->id,
                    'number' => $j
                ];
            }
        }
        Episode::insert($episodes);

        return to_route('series.index')
            ->with('message', "Série '{$serie->nome}' adicionada com sucesso");
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