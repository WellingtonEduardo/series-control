<?php

namespace App\Http\Controllers;

use App\Models\Season;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EpisodesController extends Controller
{
    public function index(Request $request, Season $season)
    {
        $episodes = $season->episodes()->get();
        $message = $request->session()->get('message');
        return view('episodes.index')
            ->with('episodes', $episodes)
            ->with('message', $message);
    }
    public function update(Request $request, Season $season)
    {
        $watchedEpisodes = $request->input('episodes', []);

        // Condicional SQL para atualizar todos os episódios em uma única consulta
        $season->episodes()->update([
            'watched' => DB::raw("CASE WHEN number IN (" . implode(',', $watchedEpisodes) . ") THEN true ELSE false END")
        ]);

        return redirect("/seasons/{$season->id}/episode")
            ->with('message', "Episódios modificados com sucesso");
    }


}