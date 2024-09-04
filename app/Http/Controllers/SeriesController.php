<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Authentication;
use App\Http\Requests\SeriesFormRequest;
use App\Mail\SeriesCreated;
use App\Models\Series;
use App\Models\User;
use App\Repositories\SeriesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $series = $this->seriesRepository->store($request);

        $usersAll = User::all();

        foreach ($usersAll as $i => $user) {
            $went = now()->addSecond($i * 10);
            $email = new SeriesCreated($request->name, "/");
            Mail::to($user->email)->later($went, $email);
        }



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