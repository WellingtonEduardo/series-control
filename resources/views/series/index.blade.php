<x-layout title="Séries">
    <a href="/series/create" class="btn btn-primary mb-2">Adicionar</a>

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-item-center">
                {{ $serie->name }}

                <form action="/series/{{ $serie->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit">
                        X
                    </button>
                </form>
            </li>
        @endforeach
    </ul>
</x-layout>
