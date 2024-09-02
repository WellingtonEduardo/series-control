<x-layout title="editar Série">
    <form action="/series/{{ $series->id }}" method="post">
        @csrf
        @method('PUT')
        <div class="row mb-3">
            <div class="col-8">
                <label for="name" class="form-label">Nome:</label>
                <input type="text" autofocus id="name" name="name" class="form-control"
                    value="{{ $series->name }}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Nº Temporadas:</label>
                <input type="text" id="seasonsQty" name="seasonsQty" class="form-control"
                    value="{{ $series->seasonsQty }}">
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Eps / Temporada:</label>
                <input type="text" id="episodesPerSeason" name="episodesPerSeason" class="form-control"
                    value="{{ $series->episodesPerSeason }}">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Editar</button>
    </form>
</x-layout>
