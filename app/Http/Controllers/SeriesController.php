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

        // Busca todas as temporadas existentes junto com os episódios, em uma única consulta
        $existingSeasons = $series->seasons()->with('episodes')->get()->keyBy('number');

        // Lista para novas temporadas e novos episódios
        $newSeasons = [];
        $newEpisodes = [];

        // Atualiza ou cria temporadas e episódios
        for ($i = 1; $i <= $request->seasonsQty; $i++) {
            $season = $existingSeasons->get($i);

            if (!$season) {
                // Se a temporada não existe, cria uma nova
                $newSeasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            } else {
                // Se a temporada já existe, atualiza ou cria os episódios
                $existingEpisodes = $season->episodes->keyBy('number');

                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    if (!$existingEpisodes->has($j)) {
                        // Criar novo episódio se não existir
                        $newEpisodes[] = [
                            'season_id' => $season->id,
                            'number' => $j,
                        ];
                    }
                }
            }
        }

        // Inserir novas temporadas e episódios em um único comando
        if (!empty($newSeasons)) {
            Season::insert($newSeasons);
        }

        if (!empty($newEpisodes)) {
            Episode::insert($newEpisodes);
        }

        // Remover temporadas que excedem a quantidade desejada
        $series->seasons()->where('number', '>', $request->seasonsQty)->delete();

        // Remover episódios que excedem a quantidade desejada por temporada, em uma única consulta
        Episode::whereIn('season_id', $series->seasons->pluck('id'))
            ->where('number', '>', $request->episodesPerSeason)
            ->delete();

        return redirect('/series')
            ->with('message', "Série '{$series->nome}' atualizada com sucesso");
    }





    public function destroy(Series $series)
    {
        $series->delete();

        return redirect('/series')
            ->with('message', "Series {$series->name} deletada com sucesso!");


    }
}
