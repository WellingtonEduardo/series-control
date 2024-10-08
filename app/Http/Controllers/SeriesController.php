<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated;
use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
    }
    public function index(Request $request)
    {
        $series = $this->seriesRepository->index();
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
        $coverPath = $request->file('cover')?->store('series-path', 'public');
        $request->cover = $coverPath;
        $series = $this->seriesRepository->store($request);
        SeriesCreated::dispatch($request->name);

        return to_route('series.index')
            ->with('message', "Série {$series->name} adicionada com sucesso");
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
        $this->seriesRepository->update($request, $series);
        return redirect('/series')
            ->with('message', "Série {$series->name} atualizada com sucesso");
    }





    public function destroy(Series $series)
    {
        $this->seriesRepository->destroy($series);
        return redirect('/series')
            ->with('message', "Series {$series->name} deletada com sucesso!");


    }
}