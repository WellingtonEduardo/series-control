<x-layout title="Lista das series">
    <a href="/series/create">Adicionar nova serie</a>
    <div>
        @foreach ($series as $serie)
            <ul>
                <li>{{ $serie }}</li>
            </ul>
        @endforeach
    </div>
</x-layout>
