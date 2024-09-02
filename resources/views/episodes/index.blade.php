<x-layout title="Episódios" message="{{ $message }}">

    <form method="post">
        @csrf
        <ul class="list-group">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Episódio {{ $episode->number }}

                    <input type="checkbox" name="episodes[]" value="{{ $episode->number }}" @checked($episode->watched)>

                </li>
            @endforeach

            <button type="submit" class="btn bg-primary">
                Salvar
            </button>
        </ul>
    </form>
</x-layout>
