<x-layout title="Séries">
    <a href="/series/create" class="btn btn-primary mb-2">Adicionar</a>

    @isset($message)
        <div class="alert alert alert-success" role="alert">
            {{ $message }}
        </div>
    @endisset

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-item-center">
                <a href="/series/{{ $serie->id }}/seasons">
                    {{ $serie->name }}
                </a>


                <span class="d-flex">

                    <a href="/series/{{ $serie->id }}/edit" class="btn btn-primary me-3">
                        E
                    </a>


                    <form action="/series/{{ $serie->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit">
                            X
                        </button>
                    </form>
                </span>
            </li>
        @endforeach
    </ul>
</x-layout>
