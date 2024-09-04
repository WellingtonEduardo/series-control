<x-layout title="Temporadas de {!! $series->name !!}">
    @if ($series->cover)
        <div class="d-flex justify-center">
            <img src="{{ asset('storage/' . $series->cover) }}" style="height: 400px" alt="Capa da série" class="img-fluid">
        </div>
    @endif

    <ul class="list-group">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                @auth <a href="/seasons/{{ $season->id }}/episode"> @endauth
                    Temporada {{ $season->number }}
                    @auth</a>@endauth

                <span class="badge bg-secondary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>
