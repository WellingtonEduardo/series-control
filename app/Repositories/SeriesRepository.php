<?php

namespace App\Repositories;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Series;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

interface SeriesRepository
{
    public function index(): Collection;

    public function store(SeriesFormRequest $request): Series;

    public function update(SeriesFormRequest $request, Series $series): void;

    public function destroy(Series $series): void;

}