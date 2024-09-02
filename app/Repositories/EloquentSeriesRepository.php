<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Episode;
use App\Models\Season;
use App\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function index(): Collection
    {
        return Series::all();

    }



    public function store(SeriesFormRequest $request): Series
    {

        return  DB::transaction(function () use ($request) {
            $series = Series::create($request->all());

            $seasons = [];
            for ($i = 1; $i <= $request->seasonsQty; $i++) {
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $request->episodesPerSeason; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j
                    ];
                }
            }
            Episode::insert($episodes);
            return $series;
        });


    }



    public function update(SeriesFormRequest $request, Series $series): void
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


    }





    public function destroy(Series $series): void
    {
        $series->delete();
    }
}