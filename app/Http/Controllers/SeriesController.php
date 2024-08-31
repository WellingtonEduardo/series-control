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
        // Atualiza os dados da série
        $series->update($request->all());

        // Atualiza as temporadas existentes ou cria novas se necessário
        $seasons = [];
        for ($i = 1; $i <= $request->seasonsQty; $i++) {
            $season = $series->seasons()->where('number', $i)->first();

            if ($season) {
                // Temporada já existe, pode ser atualizado se necessário
            } else {
                // Criar nova temporada se não existir
                $seasons[] = [
                    'series_id' => $series->id,  // Certifique-se de passar o ID correto
                    'number' => $i,
                ];
            }
        }

        // Inserir novas temporadas, se houver
        if (!empty($seasons)) {
            Season::insert($seasons);
        }

        // Atualiza os episódios existentes ou cria novos se necessário
        $episodes = [];
        foreach ($series->seasons as $season) {
            for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                $episode = $season->episodes()->where('number', $j)->first();

                if ($episode) {
                    // Episódio já existe, pode ser atualizado se necessário
                } else {
                    // Criar novo episódio se não existir
                    $episodes[] = [
                        'season_id' => $season->id,  // Certifique-se de passar o ID correto
                        'number' => $j,
                    ];
                }
            }
        }

        // Inserir novos episódios, se houver
        if (!empty($episodes)) {
            Episode::insert($episodes);
        }

        // Remover temporadas e episódios se a quantidade foi reduzida
        $series->seasons()->where('number', '>', $request->seasonsQty)->delete();
        foreach ($series->seasons as $season) {
            $season->episodes()->where('number', '>', $request->episodesPerSeason)->delete();
        }

        return to_route('series.index')
            ->with('message', "Série '{$series->nome}' atualizada com sucesso");
    }



    public function destroy(Series $series)
    {
        $series->delete();

        return redirect('/series')
            ->with('message', "Series {$series->name} deletada com sucesso!");


    }
}
