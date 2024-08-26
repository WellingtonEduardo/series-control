<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;

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
        Serie::create($request->all());
        $request->session()->flash('message', 'Serie criada com sucesso!');
        return redirect('/series');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(Request $request, string $id)
    {
        Serie::destroy($id);
        $request->session()->flash('message', 'Serie deletada com sucesso!');

        return redirect('/series');

    }
}