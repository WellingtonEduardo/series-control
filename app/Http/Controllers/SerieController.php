<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\Echo_;

class SerieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $series = Serie::all();
        return view('series.index')->with('series', $series);

    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        Serie::create($request->all());
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


    public function destroy(string $id)
    {
        Serie::destroy($id);
        return redirect('/series');

    }
}